<?php
namespace Application\Form\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ModeloCertificadoFilter implements InputFilterAwareInterface
{

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
                                'isEmpty' => 'Informe o nome'
                            )
                        )
                    )
                )
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'texto',
                'required' => true,
                'filters' => array(),
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
                'name' => 'bgFrente',
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Informe a imagem da frente do certificado'
                            )
                        )
                    ),
                    array(
                        'name' => 'Zend\Validator\File\ImageSize',
                        'options' => array(
                            'minWidth' => 1122,
                            'minHeight' => 793,
                            'maxWidth' => 1127,
                            'maxHeight' => 795,
                            'messages' => array(
                                'fileImageSizeWidthTooBig' => "A largura máxima permitida para a imagem deve ser '%maxwidth%'px, a imagem enviada tem '%width%'px ",
                                'fileImageSizeWidthTooSmall' => "A largura mínima esperada para a imagem deve ser '%minwidth%'px, a imagem enviada tem '%width%'px ",
                                'fileImageSizeHeightTooBig' => "A altura máxima permitida para a imagem deve ser '%maxheight%'px, a imagem enviada tem '%height%'px",
                                'fileImageSizeHeightTooSmall' => "A altura mínima esperada para a imagem deve ser '%minheight%'px, mas '%height%' detectado",
                                'fileImageSizeNotDetected' => "O tamanho da imagem não pôde ser detectado",
                                'fileImageSizeNotReadable' => "O arquivo não é legível ou não existe"
                            )
                        )
                    )
                )
            ]));


            $inputFilter->add($factory->createInput([
                'name' => 'bgVerso',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\File\ImageSize',
                        'options' => array(
                            'minWidth' => 1122,
                            'minHeight' => 793,
                            'maxWidth' => 1127,
                            'maxHeight' => 795,
                            'messages' => array(
                                'fileImageSizeWidthTooBig' => "A largura máxima permitida para a imagem deve ser '%maxwidth%'px, a imagem enviada tem '%width%'px ",
                                'fileImageSizeWidthTooSmall' => "A largura mínima esperada para a imagem deve ser '%minwidth%'px, a imagem enviada tem '%width%'px ",
                                'fileImageSizeHeightTooBig' => "A altura máxima permitida para a imagem deve ser '%maxheight%'px, a imagem enviada tem '%height%'px",
                                'fileImageSizeHeightTooSmall' => "A altura mínima esperada para a imagem deve ser '%minheight%'px, mas '%height%' detectado",
                                'fileImageSizeNotDetected' => "O tamanho da imagem não pôde ser detectado",
                                'fileImageSizeNotReadable' => "O arquivo não é legível ou não existe"
                            )
                        )
                    )
                )
            ]));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}