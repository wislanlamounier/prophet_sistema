<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * dos campos dinâmicos
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-28
     *
    **/
    class ControleCampo extends Controlador{

        /**
         * Método responsável por controlar a ordenação dos campos na tela
         *
         * @param String $nomTabela - tabela que deve ser controlada
         * @return Void.
         *
        **/
        public function campoOrdenacao($nomTabela){
            if($this->modelo->checaExiste('schema_campo', 'nomTabela', $nomTabela)){
                $modCampo = new ModeloCampo();
                $this->visualizador->atribuirValor('arrCamposPais', $modCampo->getCampos($nomTabela, true));
                $this->visualizador->atribuirValor('arrCamposFilhos', $modCampo->getFilhos($nomTabela));

                $this->visualizador->addJs('js/campoOrdenacao.js');

                $this->visualizador->mostrarNaTela('ordenacao', 'Mudar ordem visualização - '.ucfirst($nomTabela));
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por modificar a sequência de um campo
         *
         * @return Void.
         *
        **/
        public function campoOrdenacaoFim(){
            $cdnCampo = $_GET['cdnCampo'];
            $codSequencial = $_GET['codSequencial'];

            $modCampo = new ModeloCampo();

            $modCampo->campoOrdenacaoFim($_GET['cdnCampo'], $_GET['codSequencial']);

            return;
        }

        /**
         * Método responsável pelo callback da requisição de campo existente
         *
         * @param Integer $cdnCampo - código numérico do campo
         *
        **/
        public function campoCallbackExiste($cdnCampo){
            echo $this->modelo->checaExiste('schema_campo', 'cdnCampo', $cdnCampo) ? 1 : 0;
        }

        /**
         * Método responsável por checar se um campo de nome específico exite
         *
         * @param String $nomCampo - nome do campo
         * @return Boolean - true se existe, false se não
         *
        **/
        public static function campoExiste($nomCampo){
            $modelo = new Modelo();

            $arrCond = array('nomCampo' => $nomCampo);

            $arrCampo = $modelo->consultar('schema_campo', '*', $arrCond);
            
            return count($arrCampo) > 0;
        }


    }