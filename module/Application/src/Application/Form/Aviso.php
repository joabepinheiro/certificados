<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class Aviso extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        $this->setAttribute('enctype', "multipart/form-data");
        
        $this->setInputFilter((new Filter\Aviso())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $curso = new ObjectSelect('curso');
        $curso->setOptions(array(
            'label' => 'Curso <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Curso',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll'
            ),
            'empty_item_label' => 'Para todos'
        ))->setAttribute('id', 'curso');
        $curso->setValue(0);
        $this->add($curso);
        
        $conteudo = new Element\Textarea('conteudo');
        $conteudo->setLabel('Conteúdo')->setAttributes(array(
            'placeholder' => 'Conteúdo',
            'rows' => 8,
            'required',
            'required'
        ));
        $this->add($conteudo);
        
        $submit = new Element\Submit('submit');
        $submit->setLabel('Enviar');
        $this->add($submit);
    }
}