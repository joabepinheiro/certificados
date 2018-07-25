<?php
namespace Application\Form\Validator;

use Zend\Session\Container;
use Zend\Validator\AbstractValidator;
use Zend\Config\Reader\Xml;

class CnpjDaNfe extends AbstractValidator
{

    const VALID = false;

    private $cnpj;

    protected $messageTemplates = array(
        self::VALID => "A nota  '%value%' não pertence ao cliente selecionado"
    );

    /**
     *
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $reader = new Xml();
        $data = $reader->fromFile($value['tmp_name']);
        
        $cnpjNfe = preg_replace("/[^0-9]/", "", $data['NFe']['infNFe']['dest']['CNPJ']);
        
        if (preg_replace("/[^0-9]/", "", $this->cnpj) == $cnpjNfe) {
            return true;
        }
        
        return false;
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

    /**
     *
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }
}