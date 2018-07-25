<?php
namespace Application\Form\Filter;

use Doctrine\ORM\EntityManager;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Aluno implements InputFilterAwareInterface
{

    protected $inputFilter;

    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
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
                'name' => 'nome',
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
                                'isEmpty' => 'Informe o nome do aluno'
                            )
                        )
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'email',
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'login',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Informe o CPF do aluno'
                            )
                        )
                    ),
                    array(
                        'name' => 'Application\Form\Validator\DbUniqueObject',
                        'options' => array(
                            'em' => $this->em, // Entity manager
                            'entity' => 'Application\Entity\Aluno', // Entity name
                            'field' => 'login', // column name
                            'exclude_id' => null, // id to exclude (useful in case of editing)
                            'messages' => array(
                                'objectAlreadyExists' => 'O CPF informado já está sendo utilizado por outro usuário'
                            )
                        )
                    )
                ),
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'Int'
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'senha',
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
                                'isEmpty' => 'Informe a senha que será utilizada pelo aluno'
                            )
                        )
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'confirmarsenha',
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
                        'name' => 'identical',
                        'options' => array(
                            'token' => 'senha',
                            'messages' => array(
                                \Zend\Validator\Identical::NOT_SAME => 'As senhas informadas nos dois campos não são iguais'
                            )
                        )
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Confirme a senha do aluno'
                            )
                        )
                    )
                
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'curso',
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
                                'isEmpty' => 'Informe o curso do aluno'
                            )
                        )
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'turma',
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
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}