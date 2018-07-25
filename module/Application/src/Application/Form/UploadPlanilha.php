<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class UploadPlanilha extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-inline');
        $this->setAttribute('class', 'form-upload');
        
        $this->setInputFilter((new Filter\UploadPlanilha())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $file = new Element\File('planilha');
        $this->add($file);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }
}