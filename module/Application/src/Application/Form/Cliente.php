<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Cliente extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Cliente())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $tipo = new Element\Select('tipo');
        $tipo->setLabel('Documento de Cadastro <span class="required" aria-required="true"> * </span>')
            ->setAttributes(array(
            'id' => 'tipo'
        ))
            ->setValueOptions(array(
            NULL => '',
            'fisica' => 'Física',
            'juridica' => 'Juridica'
        ));
        $this->add($tipo);
        
        $numero = new Element\Text('numero_documento');
        $numero->setLabel('Número do documento  <span class="required" aria-required="true"> * </span>')
            ->setAttributes(array(
            'placeholder' => 'Número do documento',
            'id' => 'numero_documento'
        ))
            ->setOptions(array(
            'label_attributes' => array(
                'class' => 'label_numero_documento'
            )
        ));
        $this->add($numero);
        
        $nome_ou_razao_social = new Element\Text('nome_ou_razao_social');
        $nome_ou_razao_social->setLabel('Nome ou razão Social  <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Nome / Razão Social'
        ));
        $this->add($nome_ou_razao_social);
        
        $email = new Element\Email('email');
        $email->setLabel('Email de contato  <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Email de cobrança'
        ));
        $this->add($email);
        
        $email_cobranca = new Element\Email('email_cobranca');
        $email_cobranca->setLabel('Email de cobrança  <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Email de cobrança'
        ));
        $this->add($email_cobranca);
        
        $telefone1 = new Element\Text('telefone1');
        $telefone1->setLabel('Telefone 1')->setAttributes(array(
            'placeholder' => 'Telefone 1'
        ));
        $this->add($telefone1);
        
        $telefone2 = new Element\Text('telefone2');
        $telefone2->setLabel('Telefone 2')->setAttributes(array(
            'placeholder' => 'Telefone 2'
        ));
        $this->add($telefone2);
        
        $endereco = new Element\Text('endereco');
        $endereco->setLabel('Endereço')->setAttributes(array(
            'placeholder' => 'Endereço'
        ));
        $this->add($endereco);
        
        $bairro = new Element\Text('bairro');
        $bairro->setLabel('Bairro')->setAttributes(array(
            'placeholder' => 'Bairro'
        ));
        $this->add($bairro);
        
        $cidade = new Element\Text('cidade');
        $cidade->setLabel('Cidade')->setAttributes(array(
            'placeholder' => 'Cidade'
        ));
        $this->add($cidade);
        
        $uf = new Element\Select('uf');
        $uf->setLabel('UF ')
            ->setAttributes(array(
            'id' => 'uf'
        ))
            ->setValueOptions(array(
            NULL => '',
            'ba' => 'BA'
        ));
        $this->add($uf);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}