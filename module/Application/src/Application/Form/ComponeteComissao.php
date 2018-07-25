<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class ComponeteComissao extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager, $eleicao_entity)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\ComponeteComissao())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $eleicao = new Element\Hidden('eleicao');
        $this->setValue($eleicao_entity->getId());
        $this->add($eleicao);
        
        $pessoa = new ObjectSelect('pessoa');
        $pessoa->setOptions(array(
            'label' => 'Pessoa',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Pessoa',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'getPessoasHabilitadas'
            )
        ))
            ->setAttribute('class', 'select2')
            ->setAttribute('placeholder', 'Pessoa');
        $pessoa->setValue(0);
        $this->add($pessoa);
        
        $funcoes = new ObjectSelect('funcao_comissao');
        $funcoes->setOptions(array(
            'label' => 'Função',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\FuncaoComissao',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'getFuncoesEleicao',
                'params' => array(
                    'criteria' => array(
                        'eleicao' => $eleicao_entity
                    ),
                    'orderBy' => array(
                        'id' => 'ASC'
                    )
                )
            )
        ))->setAttribute('class', 'select2');
        $funcoes->setValue(0);
        $this->add($funcoes);
        
        $descricao = new Element\Text('email');
        $descricao->setLabel('Email')->setAttributes(array(
            'placeholder' => 'Email'
        ));
        $this->add($descricao);
        
        $senha = new Element\Password('senha');
        $senha->setLabel('Senha')->setAttributes(array(
            'placeholder' => 'Senha'
        ));
        $this->add($senha);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {
        $this->get('senha')->setAttribute('description', 'Mantenha o campo em branco para manter sua antiga senha');
        $this->getInputFilter()
            ->get('senha')
            ->setRequired(false);
    }
}