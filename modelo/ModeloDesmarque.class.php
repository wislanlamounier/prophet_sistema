<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o desmarque.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-21
     *
    **/
    class ModeloDesmarque extends Modelo{

        /**
         * Método utilizado para registrar o desmarque
         * no banco de dados
         *
         * @param Object $dtoDesmarque - objeto DTO do desmarque
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function desmarqueCadastrarFim(DTODesmarque $dtoDesmarque){

                $dadosFinais = $dtoDesmarque->getArrayBanco();
                return $this->inserir('desmarque', $dadosFinais);

        }
    }
