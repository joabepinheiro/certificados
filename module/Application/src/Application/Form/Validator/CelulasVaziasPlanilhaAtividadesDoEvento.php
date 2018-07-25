<?php
namespace Application\Form\Validator;

use Zend\Filter\StringTrim;
use Zend\Session\Container;
use Zend\Validator\AbstractValidator;
use Zend\Config\Reader\Xml;

/**
 * Esse validador verifica e todas as células obrigatórias da planilha Atividades do
 * evento estão preenchidas
 *
 * Class CelulasVaziasPlanilhaAtividadesDoEvento
 * 
 * @package Application\Form\Validator
 */
class CelulasVaziasPlanilhaAtividadesDoEvento extends AbstractValidator
{

    const INVALID = 'celulaVazia';

    protected $messageTemplates = array(
        self::INVALID => 'As seguintes linhas estão com dados obrigatórios vazios: %linhas%. Corrija essas linhas e reenvie a planilha'
    );

    protected $messageVariables = array(
        'linhas' => array(
            'options' => 'linhas'
        )
    );

    protected $options = array();

    /**
     *
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($value['tmp_name']);
        $worksheet = $objPHPExcel->getAllSheets()[0];
        $linhas = $worksheet->toArray();
        
        $indice = array();
        
        // pegar indices associados as colunas Nome da atividade, Carga Horária e Tipo
        $x = 0;
        while ($row = current($linhas)) {
            
            if (in_array('Nome da atividade', $row) && in_array('Carga horária', $row) && in_array('Tipo', $row) && in_array('Data início', $row) && in_array('Data fim', $row)) {
                $indice['row'] = $x + 1;
                $indice['columns']['nome_da_atividade'] = array_search('Nome da atividade', $row, false);
                $indice['columns']['carga_horaria'] = array_search('Carga horária', $row, false);
                $indice['columns']['tipo'] = array_search('Tipo', $row, false);
                $indice['columns']['data_inicio'] = array_search('Data início', $row, false);
                $indice['columns']['data_fim'] = array_search('Data fim', $row, false);
            }
            $x ++;
            next($linhas);
        }
        
        $dados_da_linha_vazios = array(); // garda todas as lihas que contem erro
        
        /**
         * Verifica se todas as linhas estão válidas, o loopa rmazenará o número de
         * todas linhas com celula inválida
         */
        for ($x = $indice['row']; $x < count($linhas); $x ++) {
            $dados_da_linha_atual = $linhas[$x]; // linha atual a ser inserida
            $indice_da_coluna = $indice['columns']; // indices
            
            $nome_da_atividade = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['nome_da_atividade']]);
            $carga_horaria = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['carga_horaria']]);
            $data_inicio = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['data_inicio']]);
            $data_fim = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['data_fim']]);
            $tipo = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['tipo']]);
            
            if (empty($nome_da_atividade) || empty($carga_horaria) || empty($tipo) || empty($data_inicio) || empty($data_fim)) {
                $dados_da_linha_vazios[] = $x + 1;
            }
        }
        
        if (! empty($dados_da_linha_vazios)) {
            $this->options['linhas'] = implode(',  ', $dados_da_linha_vazios);
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
}