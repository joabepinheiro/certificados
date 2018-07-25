<?php
namespace Application\Form\Validator;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Zend\Filter\StringTrim;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Regex;

/**
 * Esse validador verifica se o valor das celulas são compativeis com o seu tipo
 *
 *
 * Class CelulasVaziasPlanilhaAtividadesDoEvento
 * 
 * @package Application\Form\Validator
 */
class TipoPlanilhaAtividadesDoEvento extends AbstractValidator
{

    const NAO_E_NUMERO = 'naoEnumero';

    const NAO_E_DATA_INICIO = 'naoEdataInicio';

    const NAO_E_DATA_FIM = 'naoEdataFim';

    private $validatorRegex = null;

    protected $messageTemplates = array(
        self::NAO_E_NUMERO => 'As seguintes linhas estão com a Carga horária com formatos inválidos. Linhas: %linhas%. Corrija essas linhas e reenvie a planilha',
        self::NAO_E_DATA_INICIO => 'As seguintes linhas estão com as Datas iniciais com formatos inválidos. Linhas: %linhas%. Corrija essas linhas e reenvie a planilha',
        self::NAO_E_DATA_FIM => 'As seguintes linhas estão com as Datas finais com formatos inválidos. Linhas: %linhas%. Corrija essas linhas e reenvie a planilha'
    );

    protected $messageVariables = array(
        'linhas' => array(
            'options' => 'linhas'
        )
    );

    protected $options = array();

    public function __construct($options = null)
    {
        $this->validatorRegex = new Regex('/(\d+(\.\d+)?)/');
        parent::__construct($options);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $objPHPExcel = IOFactory::load($value['tmp_name']);
        $worksheet = $objPHPExcel->getAllSheets()[0];
        $linhas = $worksheet->toArray();
        $indice = array();
        
        // pegar indices associados as colunas Nome da atividade, Carga Horária e Tipo
        $x = 0;
        while ($row = current($linhas)) {
            
            if (in_array('Nome da atividade', $row) && in_array('Carga horária', $row) && in_array('Data início', $row) && in_array('Data fim', $row) && in_array('Tipo', $row)) {
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
        
        // $nome_da_atividade_invalidas = array();
        $carga_horaria_invalidas = array();
        $data_inicio_invalidas = array();
        $data_fim_invalidas = array();
        
        /**
         * Verifica se todas as linhas estão válidas, o loopa rmazenará o número de
         * todas linhas com celula inválida
         */
        for ($x = $indice['row']; $x < count($linhas); $x ++) {
            
            $dados_da_linha_atual = $linhas[$x]; // linha atual a ser inserida
            $indice_da_coluna = $indice['columns']; // indices
                                                          
            // $nome_da_atividade = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['nome_da_atividade']]);
            $carga_horaria = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['carga_horaria']]);
            $data_inicio = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['data_inicio']]);
            $data_fim = (new StringTrim())->filter($dados_da_linha_atual[$indice_da_coluna['data_fim']]);
            
            if (! $this->validatorRegex->isValid($carga_horaria)) {
                $carga_horaria_invalidas[] = $x + 1;
            }
            
            $validator_date = new \Zend\Validator\Date();
            $validator_date->setFormat('m/d/Y');
            
            if (! $validator_date->isValid($data_inicio)) {
                $data_inicio_invalidas[] = $x + 1;
                ;
            }
            
            if (! $validator_date->isValid($data_fim)) {
                $data_fim_invalidas[] = $x + 1;
                ;
            }
        }
        
        if (! empty($carga_horaria_invalidas)) {
            $this->options['linhas'] = implode(',  ', $carga_horaria_invalidas);
            $this->error(self::NAO_E_NUMERO);
        }
        
        if (! empty($data_inicio_invalidas)) {
            $this->options['linhas'] = implode(',  ', $data_inicio_invalidas);
            $this->error(self::NAO_E_DATA_INICIO);
        }
        
        if (! empty($data_fim_invalidas)) {
            $this->options['linhas'] = implode(',  ', $data_fim_invalidas);
            $this->error(self::NAO_E_DATA_FIM);
        }
        
        if (! empty($carga_horaria_invalidas)) {
            return false;
        }
        
        if (! empty($data_inicio_invalidas)) {
            return false;
        }
        
        if (! empty($data_fim_invalidas)) {
            return false;
        }
        
        return true;
    }
}