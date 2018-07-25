<?php
namespace Application\Controller;

use Base\Controller\ActionController;
use Zend\View\Model\ViewModel;

class AdministradorController extends ActionController
{

    public function __construct()
    {}

    public function dashboardAction()
    {
        $data = (new \Application\Service\Administrador($this->getEm()))->getDataDashboard();
        return new ViewModel(array(
            'data' => $data
        ));
    }
}

