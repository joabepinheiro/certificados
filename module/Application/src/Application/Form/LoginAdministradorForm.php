<?php
namespace Application\Form;

use Application\Form\Filter\LoginAdministradorFilter;
use Base\Form\FormAbstract;

class LoginAdministradorForm extends FormAbstract
{

    public function __construct($em)
    {
        parent::__construct('');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'login-form');
        
        $this->setInputFilter((new LoginAdministradorFilter())->getInputFilter());
        
        $this->add(array(
            'name' => 'login',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Informe seu login'
            ),
            'options' => array(
                'label' => 'Informe seu login'
            )
        ));
        
        $this->add(array(
            'name' => 'senha',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Informe sua senha'
            ),
            'options' => array(
                'label' => 'Informe sua senha'
            )
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf'
        ));
    }
}