<?php
namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ConfigurarModeloCertificadoFilter implements InputFilterAwareInterface
{

    private $evento_id;

    public function __construct($evento_id)
    {
        $this->evento_id = $evento_id;
    }

    protected $inputFilter;

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
                'name' => 'evento',
                'required' => true,
            ]));


            $inputFilter->add($factory->createInput([
                'name' => 'funcoes[]',
                'required' => false,
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'tiposAtividade[]',
                'required' => false,
            ]));


            $inputFilter->add($factory->createInput([
                'name' => 'bgFrente',
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
                                'isEmpty' => 'Informe o a imagem'
                            )
                        )
                    ),
                    array(
                        'name' => 'Zend\Validator\File\Extension',
                        'options' => array(
                            'extension' => array('png', 'jpg', 'jpeg'),
                            'messages' => array(
                                'fileExtensionFalse' => 'A imagem deve ter o formato jpg ou png'
                            )
                        )
                    ),
                )
            ]));



            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}