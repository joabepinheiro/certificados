<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Administrador extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        $this->setAttribute('enctype', "multipart/form-data");
        
        $this->setInputFilter((new Filter\Administrador())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setLabel('Nome')->setAttributes(array(
            'placeholder' => 'Nome'
        ));
        $this->add($nome);
        
        $login = new Element\Text('login');
        $login->setLabel('Login')->setAttributes(array(
            'placeholder' => 'Login'
        ));
        $this->add($login);
        
        $this->add(array(
            'name' => 'senha',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Senha'
            )
        ));
        
        $this->add(array(
            'name' => 'confirmarsenha',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Confirmar Senha'
            )
        ));
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {
        $this->get('senha')->setLabel('Nova senha');
        $this->get('confirmarsenha')->setLabel('Confirmar nova senha');
        
        $this->getInputFilter()
            ->get('senha')
            ->setRequired(false);
        $this->getInputFilter()
            ->get('confirmarsenha')
            ->setRequired(false);
    }
}