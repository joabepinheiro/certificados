<?php
namespace Application\Controller;

use Base\Controller\ActionController;

class IndexController extends ActionController
{

    public function __construct()
    {}

    public function indexAction()
    {
        return $this->redirectHome();
    }

    public function negadoAction()
    {
        $view = new \Zend\View\Model\ViewModel();
        $view->setTerminal(true);
        
        return $view;
    }
}

