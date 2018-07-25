<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Funcao extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        $this->setAttribute('enctype', "multipart/form-data");
        
        $this->setInputFilter((new Filter\Funcao())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setLabel('Nome')->setAttributes(array(
            'placeholder' => 'Nome',
            'required',
            'required'
        ));
        $this->add($nome);
        
        $submit = new Element\Submit('submit');
        $submit->setLabel('Enviar');
        $this->add($submit);
    }
}