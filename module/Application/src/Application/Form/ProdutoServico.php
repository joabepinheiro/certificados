<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class ProdutoServico extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\ProdutoServico())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setLabel('Nome')->setAttributes(array(
            'placeholder' => 'Nome'
        ));
        $this->add($nome);
        
        $preco = new Element\Text('preco');
        $preco->setLabel('Preço')->setAttributes(array(
            'placeholder' => 'Preço'
        ));
        $this->add($preco);
        
        $descricao = new Element\Textarea('descricao');
        $descricao->setLabel('Descrição')->setAttributes(array(
            'placeholder' => 'Descrição'
        ));
        $this->add($descricao);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}