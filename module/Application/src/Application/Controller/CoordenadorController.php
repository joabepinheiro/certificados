<?php
namespace Application\Controller;

use Application\Entity\Evento;
use Base\Controller\ActionController;
use Zend\View\Model\ViewModel;

class CoordenadorController extends ActionController
{

    private $container;

    public function __construct()
    {
        $this->container = new \Zend\Session\Container('logado');
    }

    public function dashboardAction()
    {

        $container = new \Zend\Session\Container('logado');
        $evento_selecionado = $container->offsetGet('evento_selecionado');

        $evento  = null;

        /** @var  $evento Evento */
        if(is_null($this->params('id'))){
            $evento = $this->getEm()->getRepository('Application\Entity\Evento')->find($evento_selecionado['id']);
        }else{
            $evento = $this->getEm()->getRepository('Application\Entity\Evento')->find($this->params('id'));
        }


        if (! $this->podeAcessarParticipacao($evento)) {
            $this->flashMessenger()
                ->setNamespace('error')
                ->addMessage(' Você não é o coordenador desse evento e não pode visualisar ou alterar informações com essa conta ');

            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }else{
            $container = new \Zend\Session\Container('logado');
            $container->offsetSet('evento_selecionado', $evento->toArray());
        }

        $data = (new \Application\Service\Coordenador($this->getEm()))->getDataDashboard();

        return new ViewModel(array(
            'data' => $data
        ));
    }

    /**
     * Lista todosos eventos que o ususario logado atuou como coordenador
     * 
     * @return ViewModel
     */
    public function listarEventosAction()
    {
        $usuario = $this->container->offsetGet('usuario');

        $data = $this->getEm()->getRepository('Application\Entity\Evento')->eventosDoCoordenador($usuario['id']);

        return new ViewModel(array(
            'data' => $data
        ));
    }

    public function podeAcessarParticipacao(\Application\Entity\Evento $evento)
    {
        return $this->getTipoUsuarioLogado() == 'Administrador' || $evento->getUsuario()->getId() == $this->getUsuarioLogado()['id'];
    }
}

