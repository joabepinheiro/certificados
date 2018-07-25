<?php
namespace Application\Form;

use Application\Form\Filter\EsqueciSenhaFilter;
use Base\Form\FormAbstract;

class EsqueciSenhaForm extends FormAbstract
{

    public function __construct()
    {
        parent::__construct('');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        
        $this->setInputFilter((new EsqueciSenhaFilter())->getInputFilter());
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'placeholder' => 'Informe seu email',
                'class' => 'form-control',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Informe seu email'
            )
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf'
        ));
    }
}