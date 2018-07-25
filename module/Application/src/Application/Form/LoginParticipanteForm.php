<?php
namespace Application\Form;

use Application\Form\Filter\LoginParticipanteFilter;
use Base\Form\FormAbstract;

class LoginParticipanteForm extends FormAbstract
{

    public function __construct()
    {
        parent::__construct('');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'login-form');
        
        $this->setInputFilter((new LoginParticipanteFilter())->getInputFilter());
        
        $this->add(array(
            'name' => 'cpf',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control placeholder-no-fix',
                'id' => 'cpf',
                'placeholder' => 'Informe seu CPF'
            ),
            'options' => array(
                'label' => 'Informe seu login'
            )
        ));
        
        $this->add(array(
            'name' => 'data_nascimento',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control placeholder-no-fix',
                'id' => 'data_nascimento',
                'placeholder' => 'Informe sua data nascimento'
            ),
            'options' => array(
                'label' => 'Informe sua data de nascimento'
            )
        ));
    }
}