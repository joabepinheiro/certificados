<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class BuscarAlunos extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        
        $this->setAttribute('id', 'buscar-alunos');
        
        // $this->setInputFilter((new Filter\CobrancaAvulsa())->getInputFilter());
        
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
            ->setAttribute('id', 'curso')
            ->setAttribute('required', 'required');
        $curso->setValue(0);
        $this->add($curso);
        
        $turma = new Element\Select('turma');
        $turma->setLabel('Turma');
        $turma->setAttribute('id', 'turma');
        $this->add($turma);
        
        $disciplina = new Element\Select('disciplina');
        $disciplina->setLabel('Disciplina <span class="required" aria-required="true"> * </span>');
        $disciplina->setAttribute('id', 'disciplina');
        $disciplina->setAttribute('required', 'required');
        $this->add($disciplina);
        
        $situacao = array(
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'situacao',
            'attributes' => array(
                'class' => 'situacao'
            ),
            'options' => array(
                'label' => 'Situações <span class="required" aria-required="true"> * </span>',
                'value_options' => array(
                    array(
                        'value' => '.Cursando',
                        'label' => 'Cursando'
                    ),
                    array(
                        'value' => '.Aprovado',
                        'label' => 'Aprovado'
                    ),
                    array(
                        'value' => '.Dependência',
                        'label' => 'Dependência'
                    ),
                    array(
                        'value' => '.Reprovado',
                        'label' => 'Reprovado'
                    ),
                    array(
                        'value' => '.Cursará',
                        'label' => 'A cursar'
                    )
                )
            )
        );
        
        $this->add($situacao);
        
        $botao = new Element\Button('buscar');
        $botao->setValue('Buscar');
        $botao->setAttribute('id', 'buscar');
        
        $this->add($botao);
    }
}