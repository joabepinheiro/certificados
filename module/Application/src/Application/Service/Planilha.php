<?php
namespace Application\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Planilha
{

    private $objPHPExcel;

    private $sheetDefault = 0;

    public function __construct(Spreadsheet $objPHPExcel)
    {
        $this->objPHPExcel = $objPHPExcel;
    }

    public function getIndiceNumericoDaLinhaComNomsDasColunas()
    {
        $this->objPHPExcel->getAllSheets()[$this->sheetDefault];
    }

    /**
     * Essa fução mapeia a localização na tabeladecada campo obrigatório
     *
     * -1 no campo coluna inidica que todos os dados da coluna serão pegos
     */
    public function getMapCellBancoDeDados()
    {
        return array(
            
            'evento_nome' => array(
                'bd_tabela' => 'evento',
                'bd_campo' => 'nome',
                'coluna' => array(
                    'inicio' => 0,
                    'fim' => 0
                ),
                'linha' => array(
                    'inicio' => 2,
                    'fim' => - 1
                )
            ),
            
            'participante_nome' => array(
                'bd_tabela' => 'participante',
                'bd_campo' => 'nome',
                'coluna' => array(
                    'inicio' => 1,
                    'fim' => 1
                ),
                'linha' => array(
                    'inicio' => 2,
                    'fim' => - 1
                )
            ),
            
            'participante_cpf' => array(
                'bd_tabela' => 'participante',
                'bd_campo' => 'cpf',
                'coluna' => array(
                    'inicio' => 2,
                    'fim' => 2
                ),
                'linha' => array(
                    'inicio' => 2,
                    'fim' => - 1
                )
            ),
            
            'data_nascimento' => array(
                'bd_tabela' => 'participante',
                'bd_campo' => 'data_nascimento',
                'coluna' => array(
                    'inicio' => 3,
                    'fim' => 3
                ),
                'linha' => array(
                    'inicio' => 2,
                    'fim' => - 1
                )
            ),
            
            'carga_horaria' => array(
                'bd_tabela' => 'participante',
                'bd_campo' => 'carga_horaria',
                'coluna' => array(
                    'inicio' => 6,
                    'fim' => 6
                ),
                'linha' => array(
                    'inicio' => 2,
                    'fim' => - 1
                )
            )
        );
    }

    /**
     * Retorna todos os dados da coluna informada no parâmetro
     *
     * @param
     *            $nomeDaColuna
     * @return array
     */
    public function getDadosDaColuna($nomeDaColuna)
    {
        /** @var  $worksheet Worksheet */
        $worksheet_array = $this->objPHPExcel->getSheet($this->sheetDefault)->toArray();
        
        $linha_inicial = $this->getMapCellBancoDeDados()[$nomeDaColuna]['linha']['inicio'];
        $coluna = $this->getMapCellBancoDeDados()[$nomeDaColuna]['coluna']['inicio'];
        
        $result = array();
        
        for ($x = $linha_inicial; $x < count($worksheet_array); $x ++) {
            
            if (array_filter($worksheet_array[$x])) {
                $result[] = $worksheet_array[$x][$coluna];
            }
        }
        
        return $result;
    }

    public function getTodosOsDadosFiltrados()
    {
        $result = array();
        foreach ($this->getMapCellBancoDeDados() as $key => $value) {
            $value['dados'] = $this->getDadosDaColuna($key);
            $result[$key] = $value;
        }
        
        return $result;
    }
}

