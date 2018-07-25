<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element;

class Contratacao extends FormAbstract
{

    public function __construct($_name = 'Salvar', EntityManager $entityManager)
    {
        parent::__construct($_name);
        
        $this->setInputFilter((new Filter\Contratacao())->getInputFilter());
        
        $id = new Element\Hidden('id');
        $this->add($id);
        
        $cliente = new ObjectSelect('cliente');
        $cliente->setOptions(array(
            'label' => 'Cliente <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\Cliente',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAllAtivos'
            )
        ))->setAttribute('class', 'select2');
        $cliente->setValue(0);
        $this->add($cliente);
        
        $servico = new ObjectSelect('servico');
        $servico->setOptions(array(
            'label' => 'Produto ou Serviço <span class="required" aria-required="true"> * </span>',
            'object_manager' => $entityManager,
            'target_class' => 'Application\Entity\ProdutoServico',
            'is_method' => true,
            'display_empty_item' => true,
            'find_method' => array(
                'name' => 'findAll'
            )
        ))
            ->setAttribute('class', 'select2')
            ->setAttribute('required', 'required');
        $servico->setValue(0);
        $this->add($servico);
        
        $nome = new Element\Text('nome');
        $nome->setLabel('Nome da Contratação <span class="required" aria-required="true"> * </span>');
        $nome->setAttributes(array(
            'description' => 'Nome que será exibido na cobrança',
            'required' => 'required'
        ));
        $this->add($nome);
        
        $descricao = new Element\Textarea('descricao');
        $descricao->setLabel('Descrição');
        $this->add($descricao);
        
        $proxima_data_vencimento = new Element\Date('proxima_data_vencimento');
        $proxima_data_vencimento->setLabel('Próxima Data de Vencimento <span class="required" aria-required="true"> * </span>')->setAttributes(array(
            'id' => 'proxima_data_vencimento',
            'required' => 'required',
            'description' => "Esta é a data de vencimento desta contratação, ou seja, será a data de vencimento da próxima cobrança gerada automaticamente.
Esta data é atualizada após a emissão de cobrança de cada ciclo.

Você pode escolher quantos dias antes do vencimento as cobranças desta contratação devem ser emitidas para o cliente nas <a href='/configuracoes/listar'>Configurações de Cobrança</a>"
        ));
        $this->add($proxima_data_vencimento);
        
        $periodicidade = new Element\Select('periodicidade');
        $periodicidade->setLabel('Periodicidade <span class="required" aria-required="true"> * </span>')
            ->setAttributes(array(
            'id' => 'periodicidade',
            'required' => 'required'
        ))
            ->setValueOptions(array(
            NULL => '',
            'unica' => 'Única',
            'bimestral' => 'Bimestral',
            'trimestral' => 'Trimestral',
            'mensal' => 'Mensal',
            'anual' => 'Anual'
        ));
        $this->add($periodicidade);
        
        $valor = new Element\Number('valor');
        $valor->setAttributes(array(
            'step' => 0.01,
            'required' => 'required'
        ));
        $valor->setLabel('Valor <span class="required" aria-required="true"> * </span>');
        $this->add($valor);
        
        $situacao = new Element\Select('status');
        $situacao->setLabel('Situação <span class="required" aria-required="true"> * </span>')
            ->setAttributes(array(
            'required' => 'required',
            'description' => 'Selecione inativa se por hora você não deseja emitir cobranças automáticas para esta contratação.'
        ))
            ->setValueOptions(array(
            NULL => '',
            'ativa' => 'Ativa',
            'inativa' => 'Inativa'
        ));
        $this->add($situacao);
        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {}
}