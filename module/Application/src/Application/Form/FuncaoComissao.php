<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use Zend\Form\Element;

class FuncaoComissao extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\ConfiguracoesGerais($entityManager))->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $eleicao = new Element\Hidden('eleicao');
        $this->add($eleicao);
        
        $nome = new Element\Text('funcao');
        $nome->setOptions(array(
            'label' => 'Nome'
        ))
            ->setAttribute('placeholder', 'Nome da função (Ex: mesário, fiscal ...)')
            ->setAttribute('class', 'form-control');
        $this->add($nome);
        
        $quantidade = new Element\Number('quantidade');
        $quantidade->setOptions(array(
            'label' => 'Quantidade'
        ))
            ->setAttribute('placeholder', 'Quantidade')
            ->setAttribute('min', 1)
            ->setAttribute('class', 'form-control');
        $this->add($quantidade);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}