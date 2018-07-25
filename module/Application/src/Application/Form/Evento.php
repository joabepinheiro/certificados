<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class Evento extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Evento())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $nome = new Element\Text('nome');
        $nome->setLabel('Nome <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Nome',
            'required' => 'required'
        ));
        $this->add($nome);
        
        $nome = new Element\Text('sigla');
        $nome->setLabel('Sigla')->setAttributes(array(
            'placeholder' => 'Sigla'
        ));
        $this->add($nome);
        
        $ano = new Element\Number('ano');
        $ano->setLabel('Ano  <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Ano',
            'required' => 'required'
        ));
        $this->add($ano);
        
        $numero_edicao = new Element\Number('numero_edicao');
        $numero_edicao->setLabel('Número edição  <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Número edição ',
            'required' => 'required'
        ));
        $this->add($numero_edicao);
        
        $data_inicial = new Element\Text('data_inicial');
        $data_inicial->setLabel('Data inicial <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Data inicial',
            'required' => 'required',
            'class' => 'mask_date2'
        ));
        $this->add($data_inicial);
        
        $data_final = new Element\Text('data_final');
        $data_final->setLabel('Data final <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'placeholder' => 'Data final',
            'required' => 'required',
            'class' => 'mask_date2',
            'id' => 'evento'
        ));
        $this->add($data_final);
        
        $usuario = new ObjectSelect('usuario');
        $usuario->setOptions(array(
            'label' => 'Coordenador do evento <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Usuario',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll'
            )
        ))
            ->setAttribute('id', 'usuario')
            ->setAttribute('required', 'required');
        $usuario->setValue(0);
        $this->add($usuario);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {
        
        /** @var $this \Zend\View\Renderer\PhpRenderer */
        /** @var  $usuario \Application\Entity\Usuario*/
        $container = new \Zend\Session\Container('logado');
        $usuario = $container->offsetGet('usuario');
        
        if (! $usuario['is_administrador']) {
            $this->remove('usuario');
        }
        
        parent::editingMode();
    }

    public function setData($data)
    {
        $container = new \Zend\Session\Container('logado');
        $usuario = $container->offsetGet('usuario');

        if($usuario['is_coordenador_do_evento']){
          $data['usuario'] = $usuario['id'];
        }

        return parent::setData($data); // TODO: Change the autogenerated stub
    }
}