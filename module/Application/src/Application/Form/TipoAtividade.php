<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class TipoAtividade extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\TipoAtividade())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setOptions(array(
            'label' => 'Nome <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Nome ')
            ->setAttribute('class', 'form-control');
        $this->add($nome);
        
        $ano = new Element\Number('ano');
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}