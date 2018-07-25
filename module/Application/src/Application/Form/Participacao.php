<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class Participacao extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager, \Application\Entity\Evento $evento)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Curso())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $carga_horaria = new Element\Number('carga_horaria');
        $carga_horaria->setAttribute('id', 'carga_horaria');
        $carga_horaria->setOptions(array(
            'label' => 'Carga Horária <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Carga Horária')
            ->setAttribute('class', 'form-control');
        $this->add($carga_horaria);


        $qtd_bolsista = new Element\Number('qtd_bolsista');
        $qtd_bolsista->setLabel('Quantidade de bolsistas')->setAttributes(array(
            'placeholder' => 'Quantidade de bolsistas'
        ));
        $qtd_bolsista->setAttribute('id', 'qtd_bolsista');
        $this->add($qtd_bolsista);

        $tipo_atividade_value_options = $entityManager
            ->getRepository('Application\Entity\TipoAtividade')
            ->populateTiposAtividadesDoEvento(array(
                'evento_id' => $evento->getId()
            ));

        $tipo_atividade = new Element\Select('tipo_atividade');
        $tipo_atividade->setEmptyOption('');
        $tipo_atividade->setValueOptions($tipo_atividade_value_options);

        $tipo_atividade->setOptions(array(
            'label' => 'Tipo de atividades <span class="required" aria-required="true"> * </span>',
        ))
            ->setAttribute('id', 'tipo_atividade')
            ->setAttribute('required', 'required');
        $tipo_atividade->setValue(0);

        $this->add($tipo_atividade);


        $atividade_id = new Element\Select('atividade_id');
        $atividade_id->setOptions(array(
            'label' => 'Atividades <span class="required" aria-required="true"> * </span>',
        ))
            ->setAttribute('id', 'atividade_id')
            ->setAttribute('class', '');
        $this->add($atividade_id);
        
        $funcao_id = new ObjectSelect('funcao_id');
        $funcao_id->setOptions(array(
            'label' => 'Funções <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Funcao',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll'
            )
        ))
            ->setAttribute('id', 'funcao_id')
            ->setAttribute('required', 'required');
        $funcao_id->setValue(0);
        $this->add($funcao_id);
        
        $data_inicio = new Element\Text('data_inicio');
        $data_inicio->setOptions(array(
            'label' => 'Data início <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Data início')
            ->setAttribute('id', 'data_inicio')
            ->setAttribute('class', 'form-control')
            ->setAttribute('required', 'required');
        $this->add($data_inicio);
        
        $data_fim = new Element\Text('data_fim');
        $data_fim->setOptions(array(
            'label' => 'Data Fim <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Data Fim')
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'data_fim')
            ->setAttribute('required', 'required');
        $this->add($data_fim);
    }

    public function editingMode()
    {}
}