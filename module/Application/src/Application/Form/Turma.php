<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class Turma extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Turma())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $descricao = new Element\Text('descricao');
        $descricao->setOptions(array(
            'label' => 'Descrição <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Descrição ')
            ->setAttribute('class', 'form-control');
        $this->add($descricao);
        
        $ano = new Element\Number('ano');
        $ano->setOptions(array(
            'label' => 'Ano <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Ano')
            ->setAttribute('class', 'form-control');
        $this->add($ano);
        
        $curso = new ObjectSelect('curso');
        $curso->setOptions(array(
            'label' => 'Curso <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Curso',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll'
            )
        ))
            ->setAttribute('class', 'select2')
            ->setAttribute('placeholder', 'Curso');
        $curso->setValue(0);
        $this->add($curso);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}