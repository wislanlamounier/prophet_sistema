<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * de consultório
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-15
     *
    **/
    class ControleConsultorio extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de consultório
         *
         * @return Void.
         *
        **/
        public function consultorioCadastrar(){
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Consultório');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do consultorio.
         *
         * @return Void.
         *
        **/
        public function consultorioCadastrarFim(){
            $modConsultorio = new ModeloConsultorio();
			$arrValidacao = $modConsultorio->consultorioPreparaDTO();
            $dtoConsultorio = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->consultorioCadastrar();
            	return;
            }

            if($modConsultorio->consultorioCadastrarFim($dtoConsultorio)){

                $cdnConsultorio = $modConsultorio->ultimoInserido('consultorio');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'consultorio', $cdnConsultorio));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->consultorioConsultarFim($cdnConsultorio);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'consultorio', $_POST['numConsultorio']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->consultorioCadastrar();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de uma consultório.
         *
         * @param Integer $cdnConsultorio - código numérico da consultório
         * @return Void.
         *
        */
        public function consultorioAtualizar($cdnConsultorio){
            $modConsultorio = new ModeloConsultorio();
            if($modConsultorio->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
                $dtoConsultorio = $modConsultorio->getConsultorio($cdnConsultorio);
    			$this->visualizador->atribuirValor('dtoConsultorio', $dtoConsultorio);
    			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar Consultório '.$dtoConsultorio->getNumConsultorio());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * a consultório
         *
         * @param Integer $cdnConsultorio - código numérico da consultório
         * @return Void.
         *
        **/
        public function consultorioAtualizarFim($cdnConsultorio){
            $modConsultorio = new ModeloConsultorio();
            if($modConsultorio->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
				$arrValidacao = $modConsultorio->consultorioPreparaDTO($cdnConsultorio);
	            $dtoConsultorio = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->consultorioAtualizar($cdnConsultorio);
	            	return;
	            }

	            if($modConsultorio->consultorioAtualizarFim($dtoConsultorio)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'consultorio', $cdnConsultorio));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->consultorioConsultarFim($cdnConsultorio);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'consultorio', $cdnConsultorio));

	                $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->consultorioAtualizar($cdnConsultorio);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de consultórios do sistema
         *
         * @return Void
         *
        **/
        public function consultorioConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            $modConsultorio = new ModeloConsultorio();
            $this->visualizador->atribuirValor('modConsultorio', $modConsultorio);
            $this->visualizador->atribuirValor('arrConsultorios', $modConsultorio->consultar('consultorio', '*', array('indDesvinculado' => 0), 'numConsultorio'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Consultórios');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de uma
         * consultório.
         *
         * @param Integer $cdnConsultorio - código numérico da consultório
         * @return Void.
         *
        */
        public function consultorioConsultarFim($cdnConsultorio){
            if($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
            	$modConsultorio = new ModeloConsultorio();
                $dtoConsultorio = $modConsultorio->getConsultorio($cdnConsultorio);
                $this->visualizador->atribuirValor('dtoConsultorio', $dtoConsultorio);
                $this->visualizador->atribuirValor('modConsultorio', $modConsultorio);

                $this->visualizador->mostrarNaTela('consultarFim', 'Consultório '.$dtoConsultorio->getNumConsultorio());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de consultório
         *
         * @param Integer $cdnConsultorio - código numérico da consultório
         * @return Void.
         *
        **/
        public function consultorioDeletar($cdnConsultorio){
            if($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
                $modConsultorio = new ModeloConsultorio();
                $dtoConsultorio = $modConsultorio->getConsultorio($cdnConsultorio);
                $this->visualizador->atribuirValor('dtoConsultorio', $dtoConsultorio);
                $this->visualizador->atribuirValor('cdnConsultorio', $cdnConsultorio);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar Consultório '.$dtoConsultorio->getNumConsultorio());

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da consultório
         *
         * @param Integer $cdnConsultorio - código numérico da consultório
         * @return Void.
         *
        **/
        public function consultorioDeletarFim($cdnConsultorio){
            if($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
                $modConsultorio = new ModeloConsultorio();
                $dtoConsultorio = $modConsultorio->getConsultorio($cdnConsultorio);
                $dtoConsultorio->setIndDesvinculado(1);
                if($modConsultorio->consultorioAtualizarFim($dtoConsultorio)){
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'consultorio', $cdnConsultorio));
                    $this->visualizador->setFlash('Consultório deletado.', 'sucesso');
                    $this->consultorioConsultar();
                }else{
                    // Geração de log
                    $this->log(array('erro', 'delecao', 'consultorio', $cdnConsultorio));
                    $this->visualizador->setFlash('Um erro ocorreu, por favor tente novemente.', 'aviso');
                    $this->consultorioConsultarFim($cdnConsultorio);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por retornar um select de consultórios.
         *
         * @param Integer $cdnConsultorio - código numérico do consultório para selecionar de início (opcional)
         * @param Boolean $label - colocar label ou não. Padrão: true.
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param String $classe - classe do input. Padrão: iptCdnConsultorio.
         * @param String $nome - nome do input. Padrão: cdnConsultorio.
         *
         * @return String - select de consultórios
         *
        **/
        public function consultorioRetornaSelect($cdnConsultorio = 0, $label = true, $darEcho = true, $classe = 'iptCdnConsultorio', $nome = 'cdnConsultorio'){
            $modConsultorio = new ModeloConsultorio();
            $select = $modConsultorio->consultorioRetornaSelect($cdnConsultorio, $label, $classe, $nome);
            if($darEcho)
                echo $select;
            return $select;
        }

    }
