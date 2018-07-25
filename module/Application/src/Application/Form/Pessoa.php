<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Pessoa extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        $this->setAttribute('enctype', "multipart/form-data");
        
        $this->setInputFilter((new Filter\Pessoa())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setLabel('Nome <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Nome'
        ));
        $this->add($nome);
        
        $sobrenome = new Element\Text('sobrenome');
        $sobrenome->setLabel('Sobrenome <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Sobrenome'
        ));
        $this->add($sobrenome);
        
        $cpf = new Element\Text('cpf');
        $cpf->setLabel('CPF <span class="required" aria-required="true"> * </span>')
            ->setAttributes(array(
            'data-inputmask' => '"mask": "999.999.999-99"',
            'data-mask' => ''
        ))
            ->setAttributes(array(
            'placeholder' => 'CPF'
        ));
        $this->add($cpf);
        
        $telefone1 = new Element\Text('telefone1');
        $telefone1->setLabel('Telefone 1')->setAttributes(array(
            'placeholder' => 'Telefone 1',
            'data-inputmask' => '"mask": "(99) 99999-9999"',
            'data-mask' => ''
        ));
        $this->add($telefone1);
        
        $telefone2 = new Element\Text('telefone2');
        $telefone2->setLabel('Telefone 2')
            ->setAttributes(array(
            'data-inputmask' => '"mask": "(99) 99999-9999"',
            'data-mask' => ''
        
        ))
            ->setAttributes(array(
            'placeholder' => 'Telefone 2'
        ));
        $this->add($telefone2);
        
        $sexo = new Element\Select('sexo');
        $sexo->setValueOptions(array(
            '' => "",
            'M' => "masculino",
            'F' => "feminino"
        ));
        $sexo->setLabel('Sexo <span class="required" aria-required="true"> * </span>')->setAttribute('class', 'form-control select2');
        $this->add($sexo);
        
        $email = new Element\Text('email');
        $email->setLabel('Email')->setAttributes(array(
            'placeholder' => 'Informe um email válido'
        ));
        $this->add($email);
        
        $estado_civil = new Element\Select('estado_civil');
        $estado_civil->setValueOptions(array(
            '' => "",
            'solteiro(a)' => "solteiro(a)",
            'casado(a)' => "casado(a)",
            'viuvo(a)' => "viuvo(a)",
            'divorciado(a)' => "divorciado(a)"
        ));
        $estado_civil->setLabel('Estado Civil <span class="required" aria-required="true"> * </span>')->setAttribute('class', 'select2');
        $this->add($estado_civil);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}