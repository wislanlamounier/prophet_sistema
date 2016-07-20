<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do estilo
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-07
     *
    **/
    class ControleEstilo extends Controlador{

        /**
         * Método responsável por finalizar o cadastro do estilo
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        **/
        public function estiloCadastrarFim($cdnUsuario){
            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono()){
                $modEstilo = new ModeloEstilo(true);
                $arrValidacao = $modEstilo->estiloPreparaDTO();
                $dtoEstilo = $arrValidacao[0];
                $dtoEstilo->setCdnUsuario($cdnUsuario);

                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->estiloAtualizar($cdnEstilo);
                    return;
                }

                if($modEstilo->estiloCadastrarFim($dtoEstilo)){

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'estilo', $cdnUsuario));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO);
                    $this->estiloAtualizar($cdnUsuario);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'estilo', $cdnUsuario));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
                    $this->estiloAtualizar($cdnUsuario);
                    return;

                }
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os estilos de um usuário.
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        */
        public function estiloAtualizar($cdnUsuario = 0){
            $cdnUsuario = $cdnUsuario == 0 ? $_SESSION['cdnUsuario'] : $cdnUsuario;

            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono()){
                $modEstilo = new ModeloEstilo(true);
                if($modEstilo->checaExiste('estilo', 'cdnUsuario', $cdnUsuario)){
                    $dtoEstilo = $modEstilo->getEstilo($cdnUsuario);
                    $this->visualizador->atribuirValor('dtoEstilo', $dtoEstilo);
        			$this->visualizador->mostrarNaTela('atualizar', 'Modificar estilos');
                    return;
                }else{
                    $this->visualizador->atribuirValor('cdnUsuario', $cdnUsuario);
                    $this->visualizador->mostrarNaTela('cadastrar', 'Modificar estilos');
                    return;
                }
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * os estilos
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        **/
        public function estiloAtualizarFim($cdnUsuario){
            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono()){
                $modEstilo = new ModeloEstilo(true);
                if($modEstilo->checaExiste('estilo', 'cdnUsuario', $cdnUsuario)){
					$arrValidacao = $modEstilo->estiloPreparaDTO($cdnUsuario);
		            $dtoEstilo = $arrValidacao[0];
		            $dtoEstilo->setCdnUsuario($cdnUsuario);

		            $mesErro = $arrValidacao[1];

		            if($mesErro != ''){
		            	$this->visualizador->setFlash($mesErro, 'erro');
		            	$this->estiloAtualizar($cdnEstilo);
		            	return;
		            }

		            if($modEstilo->estiloAtualizarFim($dtoEstilo)){

		                // Geração de log
		                $this->log(array('sucesso', 'atualizacao', 'estilo', $cdnUsuario));

		                $this->visualizador->setFlash(SUCESSO_CADASTRO);
		                $this->estiloAtualizar($cdnUsuario);
                        return;

		            }else{

		                // Geração de log
		                $this->log(array('erro', 'atualizacao', 'estilo', $cdnUsuario));

		                $this->visualizador->setFlash(ERRO_CADASTRO);
		                $this->estiloAtualizar($cdnUsuario);
                        return;

		            }
                }
                $this->estiloAtualizar($cdnUsuario);
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por retornar o json do estilo
         *
        **/
        public function estiloGetJson(){
            $dtoEstilo = unserialize($_SESSION['dtoEstilo']);
            if(is_null($dtoEstilo)){
                $modEstilo = new ModeloEstilo(true);
                $dtoEstilo = $modEstilo->getEstilo();
                $_SESSION['dtoEstilo'] = serialize($dtoEstilo);
            }
            echo json_encode($dtoEstilo->getArrayDados());
            return json_encode($dtoEstilo->getArrayDados());
        }

    }
