<?php

namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class ConfiguracoesGerais extends FormAbstract{

    public function __construct($_name = 'Salvar'){
        parent::__construct($_name);

        $this->setInputFilter((new Filter\ConfiguracoesGerais())->getInputFilter());

        $dias_emissao_cobranca_antes_vencimento = new Element\Select('dias_emissao_cobranca_antes_vencimento');
        $dias_emissao_cobranca_antes_vencimento->setAttribute('class', 'form-control ');
        $dias_emissao_cobranca_antes_vencimento->setLabel('Emitir automaticamente as cobranças recorrentes <span class="required" aria-required="true"> * </span>')
            ->setValueOptions(array(
                5 => 5,
                10=> 10,
                15=> 15,
                20=> 20,
                25=> 25,
        ));
        $this->add($dias_emissao_cobranca_antes_vencimento);



        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

}