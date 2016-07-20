<?php

    /**
     * Classe que realiza o gerenciamento da geração de json para
     * as páginas de consulta (datatables)
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-30
     *
    **/
    class ControleJson extends Controlador{
        use Transformacao;

        /**
         * Método responsável por montar o json das consultas
         *
         * @param String $tipo - tipo de visualização de consultas
         * @return Void.
         *
        **/
        public function jsonConsultas($tipo){

            $modJson = new ModeloJson();
            echo $modJson->jsonConsultas($tipo);
            return;

        }

        /**
         * Método responsável por montar o json das parcerias
         *
         * @return Void.
         *
        **/
        public function jsonParcerias(){
            $modJson = new ModeloJson();
            echo $modJson->jsonParcerias();
            return;
        }

        /**
         * Método responsável por montar o json dos pacientes
         *
         * @param String $tipo - tipo do json. Padrão: consultar.
         * @return Void.
         *
        **/
        public function jsonPacientes($tipo = 'consultar'){
            $modJson = new ModeloJson();
            echo $modJson->jsonPacientes($tipo);
            return;
        }

        /**
         * Método responsável por montar o json dos prontuários
         *
         * @return Void.
         *
        **/
        public function jsonProntuarios(){
            $modJson = new ModeloJson();
            echo $modJson->jsonProntuarios();
        }

        /**
         * Método responsável por montar o json dos questionários anamneses
         *
         * @return Void.
         *
        **/
        public function jsonAnamneses(){
            $modJson = new ModeloJson();
            echo $modJson->jsonAnamneses();
        }

        /**
         * Método responsável por montar o json das tabelas de preço
         *
         * @return Void.
         *
        **/
        public function jsonTabelasPreco(){
            $modJson = new ModeloJson();
            echo $modJson->jsonTabelasPreco();
        }

        public function jsonOrcamentos($tipo = ''){
            $modJson = new ModeloJson();
            echo $modJson->jsonOrcamentos($tipo);
            return;
        }

        public function jsonProcedimentos($cdnOrcamento){
            $modJson = new ModeloJson();
            echo $modJson->jsonProcedimentos($cdnOrcamento);
            return;
        }
    }
