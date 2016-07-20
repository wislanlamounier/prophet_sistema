<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da recuperação de senha
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-12-01
     *
    **/
    class ControleRecuperacao extends Controlador{

        /**
         * Método construtor
         *
        **/
        public function __construct(){
            parent::__construct();
            $this->modelo = new ModeloRecuperacao(true);
        }

        /**
         * Método responsável por mostrar na tela a página de recuperação de senha
         *
         * @return Void.
         *
        **/
        public function recuperacaoSenha(){
            $this->visualizador->mostrarNaTela('senha', 'Recuperação de senha', false);
            return;
        }

        /**
         * Método responsável por enviar o e-mail de recuperação
         *
         * @return Void.
         *
        **/
        public function recuperacaoSenhaFim(){
            if($this->modelo->checaExiste('usuario', 'strEmail', $_POST['strEmail'])){
                $arrUsuario = $this->modelo->consultar('usuario', '*', array('strEmail' => $_POST['strEmail']))[0];

                if($this->modelo->recuperacaoSenhaFim($arrUsuario)){
                    $this->visualizador->setFlash('Uma mensagem foi enviada para seu e-mail de cadastro com as informações necessárias.');
                    $this->inicio();
                    return;
                }else{
                    $this->visualizador->setFlash('Algum problema ocorreu ao tentar recuperar sua senha. Por favor, tente novamente.', 'erro');
                    $this->recuperacaoSenhaFim();
                    return;
                }
            }
            $this->visualizador->setFlash('E-mail não cadastrado no sistema.', 'erro');
            $this->recuperacaoSenha();
            return;
        }

        /**
         * Método responsável por finalizar a recuperação
         *
         * @param String $codExterno - código da recuperação
         * @return Void.
         *
        **/
        public function recuperacaoFinalizar($codExterno){
            if($this->modelo->checaExiste('recuperacao', 'codExterno', $codExterno)){
                $dtoRecuperacao = $this->modelo->getRecuperacao($codExterno);
                if(!$dtoRecuperacao->getIndFinalizado()){
                    $this->modelo->recuperacaoEnviarSenha($dtoRecuperacao);
                    $this->visualizador->setFlash('Um e-mail com a sua nova senha foi enviado para você.', 'sucesso');
                    $this->recuperacaoSenha();
                    return;
                }
                $this->visualizador->setFlash('Esta recuperação já foi realizada.', 'erro');
                $this->recuperacaoSenha();
            }
            $this->visualizador->setFlash('Recuperação não cadastrada no sistema.', 'erro');
            $this->recuperacaoSenha();
            return;
        }

    }
