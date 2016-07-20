<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do fornecedor
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-14
     *
    **/
    class ControleFornecedor extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de fornecedor
         *
         * @return Void.
         *
        **/
        public function fornecedorCadastrar(){
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Fornecedor');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do fornecedor.
         *
         * @return Void.
         *
        **/
        public function fornecedorCadastrarFim(){
            $modFornecedor = new ModeloFornecedor();
			$arrValidacao = $modFornecedor->fornecedorPreparaDTO();
            $dtoFornecedor = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->fornecedorCadastrar();
            	return;
            }

            if($modFornecedor->fornecedorCadastrarFim($dtoFornecedor)){

                $cdnFornecedor = $modFornecedor->ultimoInserido('fornecedor');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'fornecedor', $cdnFornecedor));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->fornecedorConsultarFim($cdnFornecedor);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'fornecedor', $_POST['nomFornecedor']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->fornecedorCadastrar();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um fornecedor.
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Void.
         *
        */
        public function fornecedorAtualizar($cdnFornecedor){
            $modFornecedor = new ModeloFornecedor();
            if($modFornecedor->checaExiste('fornecedor', 'cdnFornecedor', $cdnFornecedor)){
                $dtoFornecedor = $modFornecedor->getFornecedor($cdnFornecedor);
    			$this->visualizador->atribuirValor('dtoFornecedor', $dtoFornecedor);
    			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar '.$dtoFornecedor->getNomFornecedor());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * fornecedor
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Void.
         *
        **/
        public function fornecedorAtualizarFim($cdnFornecedor){
            $modFornecedor = new ModeloFornecedor();
            if($modFornecedor->checaExiste('fornecedor', 'cdnFornecedor', $cdnFornecedor)){
				$arrValidacao = $modFornecedor->fornecedorPreparaDTO($cdnFornecedor);
	            $dtoFornecedor = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->fornecedorAtualizar($cdnFornecedor);
	            	return;
	            }


	            if($modFornecedor->fornecedorAtualizarFim($dtoFornecedor)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'fornecedor', $cdnFornecedor));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->fornecedorConsultarFim($cdnFornecedor);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'fornecedor', $cdnFornecedor));

	                $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->fornecedorAtualizar($cdnFornecedor);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de fornecedores do sistema
         *
         * @return Void
         *
        **/
        public function fornecedorConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            $modFornecedor = new ModeloFornecedor();
            $this->visualizador->atribuirValor('modFornecedor', $modFornecedor);
            $this->visualizador->atribuirValor('arrFornecedores', $modFornecedor->consultar('fornecedor'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Fornecedores');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * fornecedor.
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Void.
         *
        */
        public function fornecedorConsultarFim($cdnFornecedor){
            if($this->modelo->checaExiste('fornecedor', 'cdnFornecedor', $cdnFornecedor)){
            	$modFornecedor = new ModeloFornecedor();
                $dtoFornecedor = $modFornecedor->getFornecedor($cdnFornecedor);
                $this->visualizador->atribuirValor('dtoFornecedor', $dtoFornecedor);
                $this->visualizador->atribuirValor('modFornecedor', $modFornecedor);

                $this->visualizador->mostrarNaTela('consultarFim', $dtoFornecedor->getNomFornecedor());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de fornecedor
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Void.
         *
        **/
        public function fornecedorDeletar($cdnFornecedor){
            if($this->modelo->checaExiste('fornecedor', 'cdnFornecedor', $cdnFornecedor)){
                $modFornecedor = new ModeloFornecedor();
                $dtoFornecedor = $modFornecedor->getFornecedor($cdnFornecedor);
                $this->visualizador->atribuirValor('dtoFornecedor', $dtoFornecedor);
                $this->visualizador->atribuirValor('cdnFornecedor', $cdnFornecedor);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$dtoFornecedor->getNomFornecedor());

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do fornecedor
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Void.
         *
        **/
        public function fornecedorDeletarFim($cdnFornecedor){
            if($this->modelo->checaExiste('fornecedor', 'cdnFornecedor', $cdnFornecedor)){
                $this->modelo->deletar('fornecedor', array('cdnFornecedor' => $cdnFornecedor));
                // Geração de log
                $this->log(array('sucesso', 'delecao', 'fornecedor', $cdnFornecedor));
                $this->visualizador->setFlash('Fornecedor deletado.', 'sucesso');
                $this->fornecedorConsultar();
                return;
            }
            $this->erroExistente();
            return;
        }

    }
