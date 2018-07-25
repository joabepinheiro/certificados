<?php
namespace Application\Controller;

use Application\Form\AdicionarAtividadesDoEventoPorPlanilha;
use Application\Form\Atividade;
use Base\Controller\ActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AtividadeController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Atividade';
        $this->form = 'Application\Form\Atividade';
        $this->formService = true;
        $this->service = 'Application\Service\Atividade';
        $this->controller = 'atividade';
        $this->route = 'atividade/default';
    }

    public function cadastrarAction()
    {
        $id = $this->params('evento', 0);
        
        $evento = $this->getEm()
            ->getRepository('Application\Entity\Evento')
            ->find($id);
        
        if (is_null($evento)) {
            return $this->redirectHome();
        }
        
        if ($this->podeAcessarParticipacao($evento)) {
            $data = (new \Application\Service\Participacao($this->getEm()))->getParticipacao($evento);
        } else {
            $data = array();
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }
        
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findBy(array(
            'evento' => $evento
        ));
        
        $form = new Atividade(null, $evento, $this->getEm());
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $entity = $service->insert($form->getData());
                
                if ($entity) {
                    
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage($entity . ' cadastrado com sucesso <a href="' . $this->url()
                        ->fromRoute('participacao/default', array(
                        'action' => 'cadastrar',
                        'evento' => $evento->getId()
                    )) . '"> Voltar para tela de  participações</a>');
                    
                    $form = new Atividade(null, $evento, $this->getEm());
                    
                    return $this->redirect()->toRoute('atividade/default', array(
                        'action' => 'listar',
                        'evento' => $evento->getId()
                    ));
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'data' => $list,
            'evento' => $evento
        ));
    }

    public function editarAction()
    {
        $evento_id = $this->params('evento', 0);
        
        $evento = $this->getEm()
            ->getRepository('Application\Entity\Evento')
            ->find($evento_id);
        
        if (is_null($evento)) {
            return $this->redirectHome();
        }
        
        if ($this->podeAcessarParticipacao($evento)) {
            $data = (new \Application\Service\Participacao($this->getEm()))->getParticipacao($evento);
        } else {
            $data = array();
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }


        $form = new Atividade(null, $evento, $this->getEm());
        $form->editingMode();
        
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->getPK());
        
        if (! $entity) {
            return $this->redirect()->toRoute($this->route);
        }
        
        if ($this->params()->fromRoute('id', 0)) {
            $form->setData($entity->dataForm());
        }
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $result = $service->update($form->getData());
                
                if ($result) {
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage($entity . ' atualizado com sucesso');
                    
                    $this->redirect()->toRoute($this->route, array(
                        'action' => 'listar',
                        'evento' => $evento->getId(),
                    ));
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'entity' => $entity,
            'evento' => $evento
        ));
    }

    public function listarAction()
    {
        $evento = $this->getEm()
            ->getRepository('Application\Entity\Evento')
            ->find($this->params('evento', 0));
        if (is_null($evento)) {
            return $this->redirectHome();
        }
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findBy(array(
            'evento' => $evento
        ));
        
        return new ViewModel(array(
            'data' => $list,
            'evento' => $evento
        ));
    }

    public function detalhesAjaxAction()
    {
        $id = $this->params('id', 0);
        
        $atividade = $this->getEm()
            ->getRepository('Application\Entity\Atividade')
            ->find($id);
        
        return new JsonModel($atividade->toArray());
    }

    public function cadastrarPorPlanilhaAction()
    {
        $request = $this->getRequest();
        $evento = $this->getEm()
            ->getRepository('Application\Entity\Evento')
            ->find($this->params('evento'));
        $tipos_atividades = $this->getEm()
            ->getRepository('Application\Entity\TipoAtividade')
            ->findBy(array(), array('nome' => 'asc'));
        $atividades = $this->getEm()
            ->getRepository('Application\Entity\Atividade')
            ->findBy(array(
            'evento' => $evento
        ));
        
        if (is_null($evento)) {
            return $this->redirectHome();
        }
        
        if (! $this->podeAcessarParticipacao($evento)) {
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }
        
        $form = new AdicionarAtividadesDoEventoPorPlanilha(null, $evento->getId());
        
        if ($request->isPost()) {
            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            
            $form->setData($post);
            
            if ($form->isValid()) {
                $result = (new \Application\Service\Atividade($this->getEm()))->cadastrarPorPlanilha($post);
                
                $this->flashMessenger()
                    ->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)
                    ->addMessage($result['count_atividades_inseridas'] . ' atividades cadastradas com sucesso');
                
                return $this->redirect()->toRoute('cadastrar-atividades-por-planilha', array(
                    'evento' => $evento->getId()
                ));
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'evento' => $evento,
            'tipos_atividades' => $tipos_atividades,
            'atividades' => $atividades
        ));
    }

    public function deletarAction()
    {
        $evento = $this->getEm()
            ->getRepository('Application\Entity\Evento')
            ->find($this->params('evento'));
        
        if (is_null($evento)) {
            return $this->redirectHome();
        }
        
        if ($this->podeAcessarParticipacao($evento)) {
            $data = (new \Application\Service\Participacao($this->getEm()))->getParticipacao($evento);
        } else {
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }
        
        $this->route_params['deletar'] = array(
            'action' => 'listar',
            'evento' => $evento->getId()
        );
        
        return parent::deletarAction(); // TODO: Change the autogenerated stub
    }

    public function podeAcessarParticipacao(\Application\Entity\Evento $evento)
    {
        $bool = $this->getTipoUsuarioLogado() == 'Administrador' || $evento->getUsuario()->getId() == $this->getUsuarioLogado()['id'];
        
        if (! $bool) {
            $this->flashMessenger()
                ->setNamespace('error')
                ->addMessage(' Você não é o coordenador desse evento e não pode visualisar ou alterar informações com essa conta ');
        }
        
        return $bool;
    }

    public function detalhesAction()
    {
        $evento = $this->getEm()
            ->getRepository('Application\Entity\Evento')
            ->find($this->params('evento'));
        
        if (is_null($evento)) {
            return $this->redirectHome();
        }
        
        if ($this->podeAcessarParticipacao($evento)) {
            $data = (new \Application\Service\Participacao($this->getEm()))->getParticipacao($evento);
        } else {
            $data = array();
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }
        
        $id = $this->params('id');
        $entity = $this->getEm()
            ->getRepository($this->entity)
            ->find($id);
        
        return new ViewModel(array(
            'entity' => $entity,
            'evento' => $evento
        ));
    }
}

