<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.1 - 2015-06-10
     *
    **/
    class Controlador {

        public $modelo;
        public $visualizador;

        /**
         * Método construtor da classe
         *
         * @param String $controlador - controlador que será chamdo
         * @param String $funcao - funcao que será chamada
         *
        **/
        public function __construct($controlador = '', $funcao = ''){
            $this->modelo = new Modelo();
            $this->visualizador = new Visualizador();
            if($controlador != '' and $funcao != ''){
                include('inc/funcoes.inc.php');
                if(isset($_SESSION['cdnUsuario'])){
                    if(!in_array($funcao, $liberadas)){
                        $key = array_search($funcao, $bloqueadas);
                        if($key){
                            $modPermissao = new ModeloPermissao(true);
                            $dtoPermissao = $modPermissao->getPermissao($_SESSION['cdnUsuario']);
                            $strPermissao = $dtoPermissao->getStrPermissao();
                            $strPermissao = explode('|', $strPermissao);
                            if(!in_array($key, $strPermissao)){
                                if(!Modelo::donoStatic()){
                                    return $this->erroPermissao();
                                }
                            }
                        }
                    }
                }else{
                    if(!in_array($funcao, $liberadas)){
                        if(!Modelo::donoStatic()){
                            return $this->erroPermissao();
                        }
                    }
                }
            }
            if(BANCO != 'prophet_main'){
                $sql = 'SELECT COUNT(cdnConsulta) as qtd FROM sms_aviso_consulta_resposta WHERE indVisualizado = 0';
                $query = $this->modelo->query($sql)[0]['qtd'];
                $_SESSION['respostasNaoLidas'] = $query;
            }else{
                $_SESSION['respostasNaoLidas'] = 0;
            }
        }

        /**
         * Método utilizado para redirecionar a
         * outras páginas
         *
         * @param String $url - url da página
         *
        **/
        public function redirecionar($url){
            header('Location: '.$url);
        }

        /**
         * Método utilizado para registrar os logs
         *
         * @param Array $mensagem - Descrição do log
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function log($mensagem){
            date_default_timezone_set('Brazil/East');
            $tipo = strtoupper($mensagem[0]);
            $operacao = strtoupper($mensagem[1]);
            $modulo = strtoupper($mensagem[2]);
            if(isset($mensagem[3]))
            	$campo = $mensagem[3];
            else
            	$campo = 'SISTEMA';
            $data = date('Y-m-d H:i:s');

            if(isset($_SESSION['cdnUsuario']))
                $cdnUsuario = $_SESSION['cdnUsuario'];
            else
                $cdnUsuario = null;

        	$log = array(
        					'strInformacao' => $campo,
        					'datLog'        => $data,
        					'strTipo'       => $tipo,
        					'strOperacao'   => $operacao,
                            'cdnUsuario'    => $cdnUsuario,
        					'nomModulo'     => $modulo
        				);
        	return $this->modelo->inserir('log', $log);
        }

        /**
         * Método responsável por redirecionar o usuário para a página inicial
         *
        **/
        public function inicio(){
            if(!isset($_SESSION['nomBanco'])){
                $this->redirecionar(BASE_URL.'/main/login');
                return;
            }


            $modelo = new Modelo(false, true, 'prophet_'.$_SESSION['nomBanco']);
            $atual = $modelo->usuarioAtual();

            if(is_null($atual))
               $this->redirecionar(BASE_URL.'/main/login');

            if($atual == 'colaborador')
                $this->redirecionar(BASE_URL.'/colaborador/inicio');

            if($atual == 'dentista')
                $this->redirecionar(BASE_URL.'/dentista/inicio');

            if($atual == 'master')
                $this->redirecionar(BASE_URL.'/usuario/inicio');
        }

        /**
         * Método responsável por disparar um erro de permissao
         *
         * @param Boolean $indFlash - dar flash de erro
         *
        **/
        public function erroPermissao($indFlash = true){
            if($indFlash)
                $this->visualizador->setFlash(PERMISSAO, 'mensagem');
            $this->inicio();
        }

        /**
         * Método responsável por disparar um erro de registro não existente
         *
        **/
        public function erroExistente(){
            $this->visualizador->setFlash(NAO_EXISTE, 'mensagem');
            $this->inicio();
        }

    }
