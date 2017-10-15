<?php

/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 14/10/2017
 * Time: 18:38
 */
class CloudAshes
{

    private $input; // entrada de dados
    private $scene; // matriz extradida da entrada
    private $today; // copia da matrix do dia
    private $airports; // aeroportos atingidos [linha,coluna,dia]
    private $nAirports; // qtd de aeroportos inicais
    private $nClouds; // qtd inicial de nuvems
    private $nDays; // numero de dias
    private $nRows; // tamanho do cenarios em linhas
    private $nCols; // tamanho do cenarios em colunas
    private $result; // resultado ['msg'], ['status']

    /**
     * CloudAshes constructor.
     * @param $input
     */
    public function __construct($input)
    {
        $this->input = $input;
        //inicializa variaveis
        $this->scene = array();
        $this->airports = array();
        $this->nClouds = 0;
        $this->nAirports = 0;
        $this->nDays = 1; //começa no dia 2 pois seria a primeira iteração do loop após 24 horas do primeiro dia
        $this->sceneSize = array();
        // inicializa entrada de dados
        if ($this->parseSceneInput()) {
            // calcula resultado
            $this->calculeResult();
        } else {
            $this->result['status'] = 'danger';
            $this->result['msg'] = 'Entrada Inválida!';
        }
    }

    // converte a entrada numa matriz [][]
    private function parseSceneInput()
    {
        $nCols = -1;
        $rows = str_replace(' ', '', $this->input);
        $rows = preg_split('/$\R?^/m', $rows);
        foreach ($rows as $row) {
            $cols = str_split($row);
            //filtra entrada e remove chars invalidos
            foreach ($cols as $colKey => $col) {
                if ($col != '.' && $col != '*' && $col != 'A') {
                    unset($cols[$colKey]);
                }
            }
            $this->scene[] = $cols;
            //soma qtd de nuvems da linha
            $this->nClouds += sizeof(array_keys($cols, '*'));
            //soma qtd de aeroportos da linha
            $this->nAirports += sizeof(array_keys($cols, 'A'));

            //verifica se todas as linhas tem o mesmo numero de colunas;
            if ($nCols == -1) {
                $nCols = sizeof($cols);
            }
            if ($nCols != sizeof($cols)) {
                return false;
            }
        }
        // calcula cenário
        $this->nRows = sizeof($this->scene);
        $this->nCols = sizeof($this->scene[0]);
        return true;
    }

    // verifica se tem aeroporto e marca como nuvem quando A ou .
    private function markCloud($row, $col)
    {
        if ($row >= 0 && $row < $this->nRows && $col >= 0 && $col < $this->nCols) {
            if ($this->today[$row][$col] == 'A') {
                $this->airports[] = [$row, $col, $this->nDays];
                $this->today[$row][$col] = '*';
            } elseif ($this->today[$row][$col] == '.') {
                $this->today[$row][$col] = '*';
            }
        }
    }

    // expande a nuvem
    private function expandCloud($row, $col)
    {
        if ($this->today[$row][$col] == '*') {
            $this->markCloud($row + 1, $col);
            $this->markCloud($row - 1, $col);
            $this->markCloud($row, $col + 1);
            $this->markCloud($row, $col - 1);
        }
    }

    //calcula o resultado final
    private function calculeResult()
    {

        if ($this->nClouds <= 0) {
            $this->result['status'] = 'warning';
            $this->result['msg'] = 'Nemhuma nuvem informada!';
        } elseif ($this->nAirports <= 0) {
            $this->result['status'] = 'warning';
            $this->result['msg'] = 'Nemhum aeroporto informado!';
        } else {
            while (sizeof($this->airports) < $this->nAirports) {
                $this->today = array_values($this->scene); // copia scena
                foreach ($this->scene as $rowKey => $row) {
                    foreach ($row as $colKey => $col) {
                        if ($col == '*') {
                            $this->expandCloud($rowKey, $colKey);
                        }
                    }
                }
                $this->scene = $this->today; // atualiza scena
                $this->nDays++;
                //debug
                //$this->debug();
            }
            $this->result['status'] = 'success';
            $this->result['msg'] = 'Primeiro aeroporto atingido em: ' . $this->airports[0][2] . ' dias.';
            $this->result['msg'] .= ' / linha: ' . ($this->airports[0][0] + 1) . ', coluna: ' . ($this->airports[0][1] + 1) . '<br>';
            $this->result['msg'] .= 'Todos os aeroporto atingido em: ' . $this->airports[sizeof($this->airports) - 1][2] . ' dias.';
        }

    }

    // retorna o resultado final
    public function getResult()
    {
        return $this->result;
    }

    // função interna para testes de saida
    private function debug()
    {
        if ($this->nDays > 2) {
            die('<pre>' . var_export(['airports' => $this->airports, 'today' => $this->today], true) . '</pre>');
        }
    }


}