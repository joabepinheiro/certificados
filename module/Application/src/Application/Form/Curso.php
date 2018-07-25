<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Curso extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Curso())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setOptions(array(
            'label' => 'Nome <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Nome do curso')
            ->setAttribute('class', 'form-control');
        $this->add($nome);
        
        $descricao = new Element\Textarea('descricao');
        $descricao->setOptions(array(
            'label' => 'Descrição'
        ))
            ->setAttribute('placeholder', 'Descrição do curso')
            ->setAttribute('class', 'form-control')
            ->setAttribute('rows', '8');
        $this->add($descricao);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {}
}