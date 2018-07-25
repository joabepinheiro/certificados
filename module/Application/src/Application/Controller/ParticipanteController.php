<?php
namespace Application\Controller;

use Application\Form\CadastrarParticipantePorPlanilha;
use Application\Form\IdentificarParticipanteForm;
use Application\Service\Participante;
use Base\Controller\ActionController;
use Zend\Filter\Digits;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;

class ParticipanteController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Participante';
        $this->form = 'Application\Form\Participante';
        $this->formService = false;
        $this->service = 'Application\Service\Participante';
        $this->controller = 'participante';
        $this->route = 'participante/default';
    }



    public function indexAction()
    {
        return $this->redirect()->toRoute($this->route, array(
            'action' => 'emitir'
        ));
    }

    public function emitirAction()
    {
        $form = new IdentificarParticipanteForm();
        $request = $this->getRequest();
        $menssages = array();
        
        $view = new ViewModel();
        $view->setTerminal(true);
        $view->setVariable('participacoes', array());
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();

                $cpf                = (new Digits())->filter($data['cpf']);
                $evento_id          = (new Digits())->filter($data['evento']);
                $data_nascimento    = $data['data_nascimento'];

                $evento     = $this->getEm()->getRepository('Application\Entity\Evento')->find($evento_id);
                $partipante = $this->getEm()->getRepository('Application\Entity\Participante')->findOneBy(array(
                    'cpf'             => $cpf,
                    'dataNascimento'  => new \DateTime(substr($data_nascimento, 6, 4) . '-' . substr($data_nascimento, 3, 2) . '-' . substr($data_nascimento, 0, 2))
                ));

                $participacoes = $this->getEm()->getRepository('Application\Entity\Participacao')->getParticipacaoParticipanteNoEvento($cpf, $evento_id);
                
                $view->setVariable('partipante', $partipante);
                $view->setVariable('participacoes', $participacoes);
                $view->setVariable('evento', $evento);
                
                $form = new IdentificarParticipanteForm();
            } else {
                $menssages = current(current($form->getMessages()));
            }
        }
        
        $view->setVariable('form', $form);
        $view->setVariable('menssages', $menssages);
        
        return $view;
    }

    public function perfilAction()
    {
        return new ViewModel();
    }

    public function certificadosAction()
    {
        return new ViewModel();
    }

    public function cadastrarPorPlanilhaAction()
    {
        $form = new CadastrarParticipantePorPlanilha();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            
            $form->setData($post);
            
            if ($form->isValid()) {
                $result = (new \Application\Service\Participante($this->getEm()))->cadastrarPorPlanilha($post);
                
                if (! is_null($result)) {
                    foreach ($result['menssagens_erros'] as $key => $value) {
                        $this->flashMessenger()
                            ->setNamespace('error')
                            ->addMessage(' Linha ' . ($key + 1) . ': ' . implode(", ", $value));
                    }
                    
                    if ($result['total_participantes_inseridos'] == 1) {
                        $this->flashMessenger()
                            ->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)
                            ->addMessage($result['total_participantes_inseridos'] . ' participante inserido com sucesso');
                    } elseif ($result['total_participantes_inseridos'] > 1) {
                        $this->flashMessenger()
                            ->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)
                            ->addMessage($result['total_participantes_inseridos'] . ' participantes inseridos com sucesso');
                    }
                    else {
                        $this->flashMessenger()
                            ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                            ->addMessage('Nenhum participante inserido');
                    }
                }
                
                return $this->redirect()->toRoute($this->route, array(
                    'action' => 'cadastrar-por-planilha'
                ));
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

