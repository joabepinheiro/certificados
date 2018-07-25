<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class AdicionarAtividadesDoEventoPorPlanilha extends FormAbstract
{

    private $entityManager;

    public function __construct($_name = 'Salvar', $evento_id)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\AdicionarAtividadesDoEventoPorPlanilha())->getInputFilter());
        
        $evento = new Element\Hidden('evento');
        $evento->setValue($evento_id);
        $this->add($evento);
        
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