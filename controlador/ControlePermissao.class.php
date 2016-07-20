<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da permissão
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-18
     *
    **/
    class ControlePermissao extends Controlador{

        /**
         * Método construtor
         *
        **/
        public function __construct(){
            $this->modelo = new Modelo(true);
            $this->visualizador = new Visualizador();
        }

        /**
         * Método responsável por mostrar a página das permissões de um usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        **/
        public function permissaoAtualizar($cdnUsuario){
            $modMain = new ModeloMain(true);
            if($modMain->checaExiste('usuario', 'cdnUsuario', $cdnUsuario)){
                $arrUsuario = $modMain->getUsuario($cdnUsuario);
                
                $modPermissao = new ModeloPermissao(true);
                $arrPacotes = $modPermissao->permissaoArray($cdnUsuario);
                
                $this->visualizador->addJs('js/permissaoAtualizar.js');

                $this->visualizador->atribuirValor('cdnUsuario', $cdnUsuario);
                $this->visualizador->atribuirValor('arrPacotes', $arrPacotes);
                $this->visualizador->mostrarNaTela('atualizar', 'Mudar permissões de '.$arrUsuario['nomUsuario']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a atualização das permissões do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        **/
        public function permissaoAtualizarFim($cdnUsuario){
            $modMain = new ModeloMain(true);
            if($modMain->checaExiste('usuario', 'cdnUsuario', $cdnUsuario)){
                $modPermissao = new ModeloPermissao(true);

                if($modPermissao->permissaoAtualizarFim($cdnUsuario)){
                    $this->log(array('sucesso', 'atualizacao', 'permissao', $cdnUsuario));
                    $this->visualizador->setFlash('Permissões atualizadas com sucesso.', 'sucesso');

                    ControleMain::mainPerfil($cdnUsuario);
                }else{
                    $this->log(array('erro', 'atualizacao', 'permissao', $cdnUsuario));
                    $this->visualizador->setFlash('Ocorreu algum problema na atualização da permissão.', 'erro');
                    
                }
                return;
            }
            $this->erroExistente();
            return;
        }

    }