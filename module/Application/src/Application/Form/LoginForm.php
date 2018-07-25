<?php
namespace Application\Form;

use Application\Form\Filter\LoginFilter;
use Base\Form\FormAbstract;

class LoginForm extends FormAbstract
{

    public function __construct($em)
    {
        parent::__construct('');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        
        $this->setInputFilter((new LoginFilter())->getInputFilter());
        
        $this->add(array(
            'name' => 'login',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Informe seu login',
                'class' => 'form-control',
                'id' => 'login',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Informe seu login'
            )
        ));
        
        $this->add(array(
            'name' => 'senha',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Informe sua senha',
                'class' => 'form-control',
                'required' => 'required'
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