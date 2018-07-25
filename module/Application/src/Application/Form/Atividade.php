<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class Atividade extends FormAbstract
{

    public function __construct($_name = 'Salvar', \Application\Entity\Evento $evento_entity, EntityManager $entityManager)
    {
        parent::__construct($_name);
        $this->setAttribute('enctype', "multipart/form-data");
        
        $this->setInputFilter((new Filter\Atividade())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);


        $evento = new Element\Hidden('evento');
        $evento->setValue($evento_entity->getId());
        $evento->setAttribute('id', 'curso');

        $this->add($evento);

        $tipo_atividade = new ObjectSelect('tipo_atividade');
        $tipo_atividade->setOptions(array(
            'label' => 'Tipo atividade <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\TipoAtividade',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll'
            )
        ))
            ->setAttribute('id', 'tipo_atividade')
            ->setAttribute( 'required', 'required')
            ->setAttribute('class', '');
        $tipo_atividade->setValue(0);
        $this->add($tipo_atividade);
        
        $titulo = new Element\Text('titulo');
        $titulo->setLabel('Nome da atividade  <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Nome ',
            'required' => 'required'
        ));
        $this->add($titulo);
        
        $cargaHoraria = new Element\Number('carga_horaria');
        $cargaHoraria->setLabel('Carga Horária <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Carga Horária',
            'required' => 'required'
        ));

        $cargaHoraria->setAttributes(array(
            'min'  => '0',   // default minimum is 0
            'step' => '1',   // default interval is 1
        ));
        $this->add($cargaHoraria);
        
        $data_inicio = new Element\Text('data_inicio');
        $data_inicio->setLabel('Data início <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Data início ',
            'class' => 'mask_date',
            'required' => 'required'
        ));
        $this->add($data_inicio);
        
        $data_fim = new Element\Text('data_fim');
        $data_fim->setLabel('Data fim <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Data fim',
            'class' => 'mask_date',
            'required' => 'required'
        ));
        $this->add($data_fim);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}