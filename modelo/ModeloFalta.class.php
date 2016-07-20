<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a falta.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-21
     *
    **/
    class ModeloFalta extends Modelo{

        /**
         * Método utilizado para registrar a falta
         * no banco de dados
         *
         * @param Object $dtoFalta - objeto DTO da falta
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function faltaCadastrarFim(DTOFalta $dtoFalta){

                $dadosFinais = $dtoFalta->getArrayBanco();
                return $this->inserir('falta', $dadosFinais);

        }
    }
