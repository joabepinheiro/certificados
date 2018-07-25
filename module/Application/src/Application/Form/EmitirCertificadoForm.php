<?php
namespace Application\Form;

use Application\Form\Filter\EmitirCertificadoFilter;
use Base\Form\FormAbstract;
use Zend\Form\Element;

class EmitirCertificadoForm extends FormAbstract
{

    public function __construct()
    {
        parent::__construct('');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'login-form');
        
        $this->setInputFilter((new EmitirCertificadoFilter())->getInputFilter());
        
        $participacao = new Element\Csrf('participacao');
        $this->add($participacao);
        
        $csrf = new Element\Csrf('csrf');
        $this->add($csrf);
    }
}