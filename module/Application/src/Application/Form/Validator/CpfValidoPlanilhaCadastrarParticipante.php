<?php
namespace Application\Form\Validator;

use Zend\Session\Container;
use Zend\Validator\AbstractValidator;
use Zend\Config\Reader\Xml;

class CpfValidoPlanilhaCadastrarParticipante extends AbstractValidator
{

    const INVALID = 'formatoIncorreto';

    protected $messageTemplates = array(
        self::INVALID => "A planilha não contêm todas as colunas obrigatórias (CPF, Nome completo e  Data de nascimento)"
    );

    /**
     *
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($value['tmp_name']);
        /** @var  $worksheet \PhpOffice\PhpSpreadsheet\Worksheet */
        $worksheet = $objPHPExcel->getAllSheets()[0];
        
        $rows = $worksheet->toArray();
        
        foreach ($rows as $row) {
            var_dump($row);
            die();
        }
        
        $this->error(self::INVALID);
        
        return false;
    }
}