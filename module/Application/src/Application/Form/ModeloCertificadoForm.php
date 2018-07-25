<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class ModeloCertificadoForm extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\ModeloCertificadoFilter())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);

        $nome = new Element\Text('nome');
        $nome->setLabel('Nome <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Nome'
        ));
        $nome->setAttribute('required', 'required');
        $this->add($nome);

        
        $texto = new Element\Textarea('texto');
        $texto->setLabel('Texto <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Texto',
            'id' => 'summernote',
            'rows' => 30
        ));
        $texto->setAttribute('required', 'required');
        $this->add($texto);

        $modelo_certificado_frente = new Element\File('bgFrente');
        $modelo_certificado_frente->setLabel('Frente <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder'   => 'Frente',
            'id'            => 'bgFrente'
        ));
        $modelo_certificado_frente->setAttribute('description', 'A imagem devem estar nas dimenções A4 ');
        $modelo_certificado_frente->setAttribute('required', 'required');
        $this->add($modelo_certificado_frente);

        $modelo_certificado_verso = new Element\File('bgVerso');
        $modelo_certificado_verso->setLabel('Verso')->setAttributes(array(
            'placeholder'   => 'Verso',
            'id'            => 'bgVerso'
        ));
        $modelo_certificado_verso->setAttribute('description', 'A imagem devem estar nas dimenções A4 ');
        $this->add($modelo_certificado_verso);

        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {
        $modelo_certificado_frente = $this->get('bgFrente');
        $modelo_certificado_frente->setLabel('Frente');
        $modelo_certificado_frente->setAttribute('required', '');
        $modelo_certificado_frente->setOption('descrition', 'Mantenha o campo em branco para manter a imagem antiga');
        $this->getInputFilter()
            ->get('bgFrente')
            ->setAllowEmpty(true);
    }
}