<?php
namespace Application\Controller;

use Base\Controller\ActionController;
use Zend\View\Model\ViewModel;

class EventoController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Evento';
        $this->form = 'Application\Form\Evento';
        $this->formService = true;
        $this->service = 'Application\Service\Evento';
        $this->controller = 'evento';
        $this->route = 'evento/default';
    }

    public function participacaoAction()
    {
        $evento = $this->getEm()
            ->getRepository($this->entity)
            ->find($this->getPK());
        
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
        
        return new ViewModel(array(
            'data' => $data,
            'evento' => $evento
        ));
    }

    public function editarAction()
    {
        $this->route_params['editar'] = array(
            'action' => 'editar',
            'id'     => $this->params('id')
        );

        return parent::editarAction(); // TODO: Change the autogenerated stub
    }


    public function detalhesAction()
    {
        $evento = $this->getEm()
            ->getRepository($this->entity)
            ->find($this->getPK());
        
        if (! $this->podeAcessarParticipacao($evento)) {
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }
        
        return new ViewModel(array(
            'entity' => $evento
        ));
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
}
