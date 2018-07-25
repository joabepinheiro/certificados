<?php
namespace Application\Controller;

use Application\Form\AdicionarAtividadesDoEventoPorPlanilha;
use Application\Form\Atividade;
use Base\Controller\ActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class TipoAtividadeController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\TipoAtividade';
        $this->form = 'Application\Form\TipoAtividade';
        $this->formService = false;
        $this->service = 'Application\Service\TipoAtividade';
        $this->controller = 'tipo-atividade';
        $this->route = 'tipo-atividade/default';
    }

    public function listarAction()
    {
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findBy(array(), array('nome' => 'ASC'));

        return new ViewModel(array(
            'data' => $list,
        ));
    }

    /**
     * @return JsonModel
     */
    public function atividadesAjaxAction()
    {

        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);

        $atividade = $this->getEm()
            ->getRepository('Application\Entity\Atividade')
            ->findAtividadesDoTipoDeAtividadePopulate($id, $evento_id);

        return new JsonModel($atividade);
    }

}

