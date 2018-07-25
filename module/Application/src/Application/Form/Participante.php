<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Participante extends FormAbstract
{


    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Participante())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome_completo');
        $nome->setOptions(array(
            'label' => 'Nome completo <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', 'Nome completo')
            ->setAttribute('class', 'form-control');
        $this->add($nome);
        
        $cpf = new Element\Text('cpf');
        $cpf->setOptions(array(
            'label' => 'CPF <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', 'Cpf')
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'cpf');
        $this->add($cpf);
        
        $data_nascimento = new Element\Text('data_nascimento');
        $data_nascimento->setOptions(array(
            'label' => 'Data de nascimento <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', 'Data de nascimento')
            ->setAttribute('class', 'mask_date2');
        $this->add($data_nascimento);
        
        $email = new Element\Email('email');
        $email->setOptions(array(
            'label' => 'Email <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', 'Email')
            ->setAttribute('class', 'form-control');
        $this->add($email);
        
        $instituicao = new Element\Select('instituicao_ifba_vca');
        $instituicao->setValueOptions(array(
            ''      => '',
            'Sim'   => 'Sim',
            'Não'   =>'Não'
        ));
        $instituicao->setOptions(array(
            'label' => 'É da instituição IFBA ? <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', 'Instituição')
            ->setAttribute('class', 'form-control');
        $this->add($instituicao);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

}