<?php
namespace Application\Form\Validator;

use Zend\Session\Container;
use Zend\Validator\AbstractValidator;
use Zend\Config\Reader\Xml;

class Limite extends AbstractValidator
{

    const VALID = false;

    protected $messageTemplates = array(
        self::VALID => "O arquivo '%value%' não é uma nota fiscal"
    );

    /**
     *
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $reader = new Xml();
        $data = $reader->fromFile($value['tmp_name']);
        $this->setValue($value['name']);
        
        if (! $this->existArray(array(
            'NFe',
            'infNFe'
        ), $data)) {
            $this->error(self::VALID);
            return false;
        }
        
        return true;
    }

    public function existArray($search = array(), $source = null)
    {
        $array = $source;
        
        foreach ($search as $value) {
            if (array_key_exists($value, $array)) {
                $array = $array[$value];
            } else {
                return false;
            }
        }
        return true;
    }
}