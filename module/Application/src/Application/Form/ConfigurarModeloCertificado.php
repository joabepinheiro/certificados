<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class ConfigurarModeloCertificado extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager, \Application\Entity\Evento $evento_entity)
    {
        parent::__construct($_name);


        $this->setInputFilter((new Filter\ConfigurarModeloCertificadoFilter($evento_entity->getId()))->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);

        $evento = new Element\Hidden('evento');
        $evento->setAttribute('id', 'evento_id');
        $evento->setValue($evento_entity->getId());
        $this->add($evento);

        $nome = new Element\Text('nome');
        $nome->setLabel('Nome <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Nome'
        ));
        $nome->setAttribute('required', 'required');
        $this->add($nome);


        $texto_frente = new Element\Textarea('texto_frente');
        $texto_frente->setLabel('Texto <span class="required" aria-required="true"></span>')->setAttributes(array(
            'placeholder' => 'Texto',
            'id' => 'summernote_',
            'rows' => 30
        ));
        //$texto_frente->setAttribute('required', 'required');
        $texto_frente->setValue('Certificamos que <b>[participante_nome]</b> participou da [evento_edicao] [evento_nome] ([evento_sigla] [evento_ano]) do Instituto Federal de Educação, Ciência e Tecnologia da Bahia (IFBA) Campus Vitória da Conquista, realizada no período de [evento_periodo], com carga horária de [atividade_carga_horaria].');
        $this->add($texto_frente);

        $modelo_certificado_frente = new Element\File('bgFrente');
        $modelo_certificado_frente->setLabel('Frente <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder'   => 'Frente',
            'id'            => 'bgFrente'
        ));
        $modelo_certificado_frente->setAttribute('description', 'A imagem deve estar nas dimenções A4 ');
        $modelo_certificado_frente->setAttribute('required', 'required');
        $this->add($modelo_certificado_frente);

        $tipo = new Element\Select('tipo');
        $tipo->setLabel("Tipo");
        $tipo->setAttribute('id','tipo');
        $tipo->setValueOptions(array(
            'frente_verso'  => 'Frente e verso',
            'frente'        =>  'Frente'
        ));
        $tipo->setValue('frente');
        $this->add($tipo);

        $modelo_certificado_verso = new Element\File('bgVerso');
        $modelo_certificado_verso->setLabel('Verso')->setAttributes(array(
            'placeholder'   => 'Verso',
            'id'            => 'bgVerso'
        ));
        $modelo_certificado_verso->setAttribute('description', 'A imagem deve estar nas dimenções A4 e orientação paisagem');
        $this->add($modelo_certificado_verso);

        $texto_verso = new Element\Textarea('texto_verso');
        $texto_verso->setLabel('Texto <span class="required" aria-required="true">  </span>')->setAttributes(array(
            'placeholder' => 'Texto',
            'id' => 'summernote_2',
            'rows' => 30
        ));
        //$texto_verso->setAttribute('required', 'required');
        $this->add($texto_verso);


        $tiposAtividades = new ObjectSelect('tiposAtividade[]');
        $tiposAtividades->setOptions(array(
            'label' => 'Tipos de atividades',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\TipoAtividade',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll',
            )
        ));

        $tiposAtividades->setAttribute('required', 'required');
        $tiposAtividades->setAttribute('class', 'tiposAtividade');
        $tiposAtividades->setValue(0);
        $this->add($tiposAtividades);


        $funcoes = new ObjectSelect('funcoes[]');
        $funcoes->setOptions(array(
            'label' => 'Funções',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Funcao',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array(),
                    'orderBy' => array(
                        'nome' => 'ASC'
                    )
                )
            )
    ));
        $funcoes->setAttribute('required', 'required');
        $funcoes->setAttribute('class', 'funcoes');
        $funcoes->setValue(0);
        $this->add($funcoes);

        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {
        $this->get('bgFrente')->setAttribute('description', 'A imagem deve estar nas dimenções A4 e orientação paisagem (Mantenha o campo vazio para manter a imagem original)');
        $this->get('bgFrente')->setAttribute('required', '');

        $this->getInputFilter()->remove('bgFrente');
    }
}