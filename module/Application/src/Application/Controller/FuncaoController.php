<?php
namespace Application\Controller;

use Base\Controller\ActionController;
use Zend\View\Model\ViewModel;

class FuncaoController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Funcao';
        $this->form = 'Application\Form\Funcao';
        $this->formService = false;
        $this->service = 'Application\Service\Funcao';
        $this->controller = 'funcao';
        $this->route = 'funcao/default';
    }

    public function listarAction()
    {
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findBy(array(), array('nome' => 'ASC'));



        return new ViewModel(array(
            'data' => $list
        ));
    }
}

