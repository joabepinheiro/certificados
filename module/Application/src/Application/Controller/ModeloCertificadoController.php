<?php
namespace Application\Controller;

use Application\Form\ModeloCertificadoForm;
use Application\Service\ModeloCertificado;
use Base\Controller\ActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Service\CertificadoTipoFuncaoEvento;

class ModeloCertificadoController extends ActionController
{

    public function __construct()
    {
        $this->entity       = 'Application\Entity\ModeloCertificado';
        $this->form         = 'Application\Form\ModeloCertificadoForm';
        $this->formService  = true;
        $this->service      = 'Application\Service\ModeloCertificado';
        $this->controller   = 'modelo-certificado';
        $this->route        = 'modelo-certificado/default';
    }

    public function cadastrarAction()
    {

        $form = new ModeloCertificadoForm(null, $this->getEm());
        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $data = $request->getPost()->toArray();
            $files = $request->getFiles();

            $data = array_merge($data, [
                'bgFrente' => $files['bgFrente'],
                'bgVerso'  => $files['bgVerso']
            ]);
            
            $form->setData($data);
            
            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);

                $entity = $service->insert($data);
                
                if ($entity) {
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage($entity . ' cadastrado com sucesso');
                    
                    $form = new ModeloCertificadoForm(null, $this->getEm());
                    $this->redirect()->toRoute($this->route, array(
                        'action' => 'editar', 'id' => $entity->getId()
                    ));
                }
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }



    public function editarAction()
    {

        $id = $this->params('id', 0);
        /** @var  $modelo \Application\Entity\ModeloCertificado */
        $modelo = $this->getEm()->getRepository('Application\Entity\ModeloCertificado')->find($id);

        /** @var  $evento \Application\Entity\Evento*/
        /** @var  $usuario \Application\Entity\Usuario*/
        $container = new \Zend\Session\Container('logado');
        $usuario = $container->offsetGet('usuario');

        $form = new ModeloCertificadoForm(null, $this->getEm());
        $form->editingMode();

        if ($this->params()->fromRoute('id', 0)) {
            $data  = $modelo->dataForm();
            $form->setData($data);
        }
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $data = $request->getPost()->toArray();
            $files = $request->getFiles();
            
            $data = array_merge($data, [
                'bgFrente' => $files['bgFrente'],
                'bgVerso'  => $files['bgVerso']
            ]);

            $form->setData($data);
            
            if ($form->isValid()) {
                $service = new ModeloCertificado($this->getEm());
                $entity = $service->update($data);
                
                if ($entity) {
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage($entity . ' atualizado com sucesso');
                    
                    $form = new ModeloCertificadoForm(null, $this->getEm());
                    $this->redirect()->toRoute($this->route, array(
                        'action' => 'editar', 'id' => $id
                    ));
                }
            }
        }
        
        return new ViewModel(array(
            'form'   => $form,
            'modelo' => $modelo
        ));
    }

    public function deletarAction()
    {
        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);

        if ($this->pageDelete) {
            return $this->deletarDetailsAction();
        } else {
            $service = $this->getServiceLocator()->get($this->service);

            $row = $this->getEm()
                ->getRepository($this->entity)
                ->findOneBy(array(
                'id' => $id
            ));
            
            if ($row) {
                $id = $service->delete($id);
                
                if (! is_null($id)) {
                    $this->flashMessenger()
                        ->setNamespace(FlashMessenger::NAMESPACE_ERROR)
                        ->addMessage($row . ' removido');
                }
            }
        }
        
        return $this->redirect()->toRoute('configurar-modelo-certificado/default', array(
            'action' => 'listar',
            'evento' => $evento_id
        ));
    }

    public function deletarCriterioAction()
    {
        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);


        $service = new CertificadoTipoFuncaoEvento($this->getEm());
        /** @var  $row \Application\Entity\CertificadoTipoFuncao */
        $row = $this->getEm()
            ->getRepository('Application\Entity\CertificadoTipoFuncao')
            ->findOneBy(array(
                'id' => $id
            ));


        if ($row) {
            $id = $service->delete(array(
                'id' => $id
            ));

            if (! is_null($id)) {
                $this->flashMessenger()
                    ->setNamespace(FlashMessenger::NAMESPACE_ERROR)
                    ->addMessage("Critério ". $row. " do modelo ".$row->getModeloCertificado()->getNome(). ' removido');
            }
        }


        return $this->redirect()->toRoute($this->route, array(
            'action' => 'cadastrar',
            'evento' => $evento_id
        ));
    }

    public function previewAction()
    {
        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);
        
        $modelo = $this->getEm()
            ->getRepository($this->entity)
            ->getModeloComTexto($id);
        
        var_dump($modelo);
        die();
    }

    public function carregarAjaxAction(){
        $id = $this->params('id', 0);

        $modelo = $this->getEm()->getRepository('Application\Entity\ModeloCertificado')->find($id);

        return new JsonModel($modelo->toArray());
    }


    public function podeAcessarParticipacao(\Application\Entity\Evento $evento)
    {
        return $this->getTipoUsuarioLogado() == 'Administrador' || $evento->getUsuario()->getId() == $this->getUsuarioLogado()['id'];
    }
}

