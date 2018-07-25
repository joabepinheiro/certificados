<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Contato extends FormAbstract
{

    public function __construct($_name = 'Enviar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Contato())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $this->add(array(
            'name' => 'assunto',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Assunto'
            ),
            'options' => array(
                'label' => 'Assunto'
            )
        ));
        
        $this->add(array(
            'name' => 'descricao',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'placeholder' => 'Descrição detalhada do problema',
                'rows' => '10'
            ),
            'options' => array(
                'label' => 'Descricão'
            )
        ));
        
        $this->add(array(
            'name' => 'erro',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'rows' => '10'
            ),
            'options' => array(
                'label' => 'Texto do erro (opcional)'
            )
        ));
        
        $submit = new Element\Submit('submit');
        $submit->setLabel($_name);
        $this->add($submit);
    }

    public function modeEdition()
    {}
}