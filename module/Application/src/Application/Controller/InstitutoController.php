<?php
namespace Application\Controller;

use Base\Controller\ActionController;

class InstitutoController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Instituto';
        $this->form = 'Application\Form\Instituto';
        $this->formService = false;
        $this->service = 'Application\Service\Instituto';
        $this->controller = 'instituto';
        $this->route = 'instituto/default';
    }
}

