<?php
namespace Base\Form;

use Zend\Form\Form;

abstract class FormAbstract extends Form
{

    protected $editingMode = false;

    public function __construct($_name = null)
    {
        parent::__construct($_name);
    }

    public function editingMode()
    {
        $this->editingMode = true;
    }
}
