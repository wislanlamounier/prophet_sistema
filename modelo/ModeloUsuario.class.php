<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o usuário.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-07
     *
    **/
    class ModeloUsuario extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do usuário requisitado
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getUsuario($cdnUsuario){
            return $this->getRegistro('usuario_master', 'cdnUsuario', $cdnUsuario);
        }

        /**
         * Método utilizado para atualizar as informações do usuário
         *
         * @param Object $dtoUsuario - objeto DTO do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function usuarioAtualizarFim(DTOUsuario $dtoUsuario){

            $modMain = new ModeloMain(true);
            if($modMain->mainAtualizarUsuario($dtoUsuario->getCdnUsuario())){
    			$dados = $dtoUsuario->getArrayBanco();
                return $this->atualizar('usuario_master', $dados, array('cdnUsuario' => $dtoUsuario->getCdnUsuario()));
            }else{
                return false;
            }

        }

        /**
         * Método utilizado para preencher o DTO do usuário para cadastro.
         *
         * @param Boolean $cdnUsuario - código numérico do usuário (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function usuarioPreparaDTO($cdnUsuario = 0){
        	if($cdnUsuario == 0){
                // está cadastrando
        		$dtoUsuario = new DTOUsuario();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario))
                    return array(new DTOUsuario(), 'Registro não existente.');
    			$dtoUsuario = $this->getUsuario($cdnUsuario);
        	}

            $mesErro = '';

            if(isset($_POST['strSenha'])){
                if(!isset($_POST['confSenha'])){
                    $mesErro .= 'Senhas não conferem.';
                }else{
                    if(trim($_POST['strSenha']) != '' or trim($_POST['confSenha']) != ''){
                        if($_POST['strSenha'] != $_POST['confSenha'])
                            $mesErro .= 'Senhas não conferem. <br>';
                    }else{
                        if($cdnUsuario == 0)
                            $mesErro .= 'Informe a senha. <br>';
                    }
                }
            }

            if($cdnUsuario == 0){
                $modMain = new ModeloMain(true);
                if($modMain->mainChecaExisteEmail())
                    $mesErro .= 'Este e-mail já está cadastrado no sistema. <br>';
            }

			return array($dtoUsuario, $mesErro);
        }

        /**
         * Método utilizado para registrar o usuário
         * no banco de dados
         *
         * @param Object $dtoUsuario - objeto DTO do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function usuarioCadastrarFim(DTOUsuario $dtoUsuario){

            $modMain = new ModeloMain(true);
            $cdnUsuarioMain = $modMain->mainCadastrarUsuario();
            if($cdnUsuarioMain !== false){
                $dtoUsuario->setCdnUsuario($cdnUsuarioMain);
                $dadosFinais = $dtoUsuario->getArrayBanco();
                if($this->inserir('usuario_master', $dadosFinais)){
                    return true;
                }else{
                    $modMain->deletar('usuario', array('cdnUsuario' => $cdnUsuarioMain));
                    return false;
                }
            }
            return false;

        }

        /**
         * Método responsável por transformar um usuário em master
         *
         * @param Object $dtoUsuario - objeto DTO do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function usuarioMasterFim($dtoUsuario){
            $arrDados = $dtoUsuario->getArrayBanco();

            return $this->inserir('usuario_master', $arrDados);
        }
    }
