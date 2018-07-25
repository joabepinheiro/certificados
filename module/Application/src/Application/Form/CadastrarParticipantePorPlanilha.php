<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class CadastrarParticipantePorPlanilha extends FormAbstract
{

    private $entityManager;

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\CadastrarParticipantePorPlanilha())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\File('planilha');
        $nome->setOptions(array(
            'label' => 'Planilha <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', 'Planilha')
            ->setAttribute('class', 'form-control');
        $this->add($nome);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {}
}