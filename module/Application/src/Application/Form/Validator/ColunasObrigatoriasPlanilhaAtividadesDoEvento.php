<?php
namespace Application\Form\Validator;

use Zend\Session\Container;
use Zend\Validator\AbstractValidator;
use Zend\Config\Reader\Xml;

class ColunasObrigatoriasPlanilhaAtividadesDoEvento extends AbstractValidator
{

    const INVALID = 'formatoIncorreto';

    protected $messageTemplates = array(
        self::INVALID => "A planilha não contêm todas as colunas obrigatórias (Nome da atividade, Carga Horária,  Tipo, Data início e Data fim)"
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
            if (in_array('Nome da atividade', $row) && in_array('Carga horária', $row) && in_array('Tipo', $row) && in_array('Data início', $row) && in_array('Data fim', $row)) {
                return true;
            }
        }
        
        $this->error(self::INVALID);
        
        return false;
    }
}