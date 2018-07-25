<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;

class Usuario extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Usuario())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $login = new Element\Text('login');
        $login->setOptions(array(
            'label' => 'Login <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Login ')
            ->setAttribute('required', 'required')
            ->setAttribute('class', 'form-control');
        $this->add($login);
        
        $email = new Element\Email('email');
        $email->setOptions(array(
            'label' => 'Email <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Email ')
            ->setAttribute('required', 'required')
            ->setAttribute('class', 'form-control');
        $this->add($email);
        
        $senha = new Element\Password('senha');
        $senha->setOptions(array(
            'label' => 'Senha <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Senha ')
            ->setAttribute('required', 'required')
            ->setAttribute('class', 'form-control');
        $this->add($senha);


        $this->add(array(
            'name' => 'confirmarsenha',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Confirmar Senha <span class="required" aria-required="true"> * </span>'
            )
        ));
        
        $tipo = new Element\Select('tipo');
        $tipo->setOptions(array(
            'label' => 'Tipo <span class="required" aria-required="true"> * </span>'
        ))
            ->setAttribute('placeholder', 'Tipo ')
            ->setAttribute('required', 'required')
            ->setAttribute('class', 'form-control');
        
        $tipo->setValueOptions(array(
            ''                      => '',
            'Administrador'         => 'Administrador',
            'Coordenador do Evento' => 'Coordenador do Evento'
        ));
        $this->add($tipo);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {
        $this->get('senha')->setLabel('Nova senha');
        $this->get('senha')->setAttribute('description', 'Deixe em branco para manter a senha antiga');

        $this->get('senha')->setAttribute('required', '');
        $this->get('confirmarsenha')->setAttribute('required', '');

        $this->getInputFilter()
        ->get('senha')
        ->setRequired(false);

        $this->getInputFilter()
            ->get('confirmarsenha')
            ->setRequired(false);
    }
}