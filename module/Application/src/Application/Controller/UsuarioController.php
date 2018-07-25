<?php
namespace Application\Controller;

use Application\Service\Usuario;
use Base\Controller\ActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;

class UsuarioController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Usuario';
        $this->form = 'Application\Form\Usuario';
        $this->formService = false;
        $this->service = 'Application\Service\Usuario';
        $this->controller = 'usuario';
        $this->route = 'usuario/default';
    }


    public function cadastrarAction()
    {

        $form = ($this->formService) ? $this->getServiceLocator()->get($this->form) : new $this->form();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data =$request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                /** @var  $service Usuario */
                $service = $this->getServiceLocator()->get($this->service);
                /** @var  $entity \Application\Entity\Usuario*/
                $entity = $service->insert($form->getData());

                if ($entity) {
                    $entity->addSenhaNoEncrypt($data['senha']);
                    if(!$service->enviarDadosDeAcesso($entity)){
                        $this->flashMessenger()
                            ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                            ->addMessage($entity . 'Usuário cadastrado mas o email não foi enviado');
                    }else{
                        $this->flashMessenger()
                            ->setNamespace('success')
                            ->addMessage($entity . ' cadastrado com sucesso');
                    }

                    $form = ($this->formService) ? $this->getServiceLocator()->get($this->form) : new $this->form();
                    $this->redirect()->toRoute($this->route, $this->route_params['cadastrar']);
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function deletarAction()
    {
        return $this->deletarDetailsAction();
    }
}

