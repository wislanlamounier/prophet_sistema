<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da frase
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-14
     *
    **/
    class ControleFrase extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de frase
         *
         * @return Void.
         *
        **/
        public function fraseCadastrar(){
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Frase');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da frase.
         *
         * @return Void.
         *
        **/
        public function fraseCadastrarFim(){
            $modFrase = new ModeloFrase();
			$arrValidacao = $modFrase->frasePreparaDTO();
            $dtoFrase = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->fraseCadastrar();
            	return;
            }

            if($modFrase->fraseCadastrarFim($dtoFrase)){

                $cdnFrase = $modFrase->ultimoInserido('frase');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'frase', $cdnFrase));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->fraseConsultarFim($cdnFrase);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'frase', $_POST['strFrase']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->fraseCadastrar();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um frase.
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        */
        public function fraseAtualizar($cdnFrase){
            $modFrase = new ModeloFrase();
            if($modFrase->checaExiste('frase', 'cdnFrase', $cdnFrase)){
                $dtoFrase = $modFrase->getFrase($cdnFrase);
                if($dtoFrase->getCdnUsuario() == $_SESSION['cdnUsuario']){
        			$this->visualizador->atribuirValor('dtoFrase', $dtoFrase);
        			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar Frase');
                    return;
                }
                $this->erroPermissao();
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * frase
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        **/
        public function fraseAtualizarFim($cdnFrase){
            $modFrase = new ModeloFrase();
            if($modFrase->checaExiste('frase', 'cdnFrase', $cdnFrase)){
				$arrValidacao = $modFrase->frasePreparaDTO($cdnFrase);
	            $dtoFrase = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->fraseAtualizar($cdnFrase);
	            	return;
	            }

                if($dtoFrase->getCdnUsuario() == $_SESSION['cdnUsuario']){


    	            if($modFrase->fraseAtualizarFim($dtoFrase)){

    	                // Geração de log
    	                $this->log(array('sucesso', 'atualizacao', 'frase', $cdnFrase));

    	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
    	                $this->fraseConsultarFim($cdnFrase);
                        return;

    	            }else{

    	                // Geração de log
    	                $this->log(array('erro', 'atualizacao', 'frase', $cdnFrase));

    	                $this->visualizador->setFlash(ERRO_CADASTRO);
    	                $this->fraseAtualizar($cdnFrase);
                        return;

    	            }
                }
                $this->erroPermissao();
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de frasees do sistema
         *
         * @return Void
         *
        **/
        public function fraseConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            $modFrase = new ModeloFrase();
            $this->visualizador->atribuirValor('modFrase', $modFrase);
            $this->visualizador->atribuirValor('arrFrases', $modFrase->consultar('frase', '*', false, 'indAtiva DESC, strFrase'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Frases');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * frase.
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        */
        public function fraseConsultarFim($cdnFrase){
            if($this->modelo->checaExiste('frase', 'cdnFrase', $cdnFrase)){
            	$modFrase = new ModeloFrase();
                $dtoFrase = $modFrase->getFrase($cdnFrase);
                $this->visualizador->atribuirValor('dtoFrase', $dtoFrase);
                $this->visualizador->atribuirValor('modFrase', $modFrase);

                $this->visualizador->mostrarNaTela('consultarFim', 'Frase');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de frase
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        **/
        public function fraseDeletar($cdnFrase){
            if($this->modelo->master()){
                if($this->modelo->checaExiste('frase', 'cdnFrase', $cdnFrase)){
                    $modFrase = new ModeloFrase();
                    $dtoFrase = $modFrase->getFrase($cdnFrase);
                    $this->visualizador->atribuirValor('dtoFrase', $dtoFrase);
                    $this->visualizador->atribuirValor('cdnFrase', $cdnFrase);
                    $this->visualizador->mostrarNaTela('deletar', 'Deletar frase');

                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da frase
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        **/
        public function fraseDeletarFim($cdnFrase){
            if($this->modelo->master()){
                if($this->modelo->checaExiste('frase', 'cdnFrase', $cdnFrase)){
                    $this->modelo->deletar('frase', array('cdnFrase' => $cdnFrase));
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'frase', $cdnFrase));
                    $this->visualizador->setFlash('Frase deletada.', 'sucesso');
                    $this->fraseConsultar();
                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por mostrar a página de ativação de frase
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        **/
        public function fraseAtivar($cdnFrase){
            if($this->modelo->master()){
                if($this->modelo->checaExiste('frase', 'cdnFrase', $cdnFrase)){
                    $modFrase = new ModeloFrase();
                    $dtoFrase = $modFrase->getFrase($cdnFrase);
                    $this->visualizador->atribuirValor('dtoFrase', $dtoFrase);
                    $this->visualizador->atribuirValor('cdnFrase', $cdnFrase);
                    $this->visualizador->mostrarNaTela('ativar', 'Ativar frase');

                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por finalizar a ativação da frase
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Void.
         *
        **/
        public function fraseAtivarFim($cdnFrase){
            if($this->modelo->master()){
                if($this->modelo->checaExiste('frase', 'cdnFrase', $cdnFrase)){
                    $this->modelo->sql('UPDATE frase SET indAtiva = 0 WHERE 1');
                    
                    $modFrase = new ModeloFrase();
                    $dtoFrase = $modFrase->getFrase($cdnFrase);
                    $dtoFrase->setIndAtiva(1);
                    $modFrase->fraseAtualizarFim($dtoFrase);

                    // Geração de log
                    $this->log(array('sucesso', 'ativar', 'frase', $cdnFrase));

                    $this->visualizador->setFlash('Frase ativada.', 'sucesso');
                    $this->fraseConsultar();
                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

    }
