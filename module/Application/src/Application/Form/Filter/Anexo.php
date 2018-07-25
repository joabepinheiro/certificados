<?php
namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Anexo implements InputFilterAwareInterface
{

    protected $inputFilter;

    protected $em;

    function __construct($em)
    {
        $this->em = $em;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Não usado");
    }

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput([
                'name' => 'item',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Informe o nome do item'
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_repository' => $this->em->getRepository('Application\Entity\Anexo'),
                            'object_manager' => $this->em,
                            'fields' => 'item',
                            'use_context' => true,
                            'messages' => array(
                                'objectNotUnique' => "O nome do item informado já está sendo utilizado"
                            )
                        )
                    
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'descricao',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Informe a descrição'
                            )
                        )
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'inicio1',
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'protocolos',
                'required' => false
            ]));
            
            for ($x = 0; $x <= 23; $x ++) {
                
                $inputFilter->add($factory->createInput([
                    'name' => 'mva_fidelidade' . $x,
                    'required' => false
                ]));
                
                $inputFilter->add($factory->createInput([
                    'name' => 'mva_aliquota' . $x,
                    'required' => false
                ]));
                
                $inputFilter->add($factory->createInput([
                    'name' => 'mva_pICMS' . $x,
                    'required' => false
                ]));
            }
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}