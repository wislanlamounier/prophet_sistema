<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do colaborador
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-10
     *
    **/
    class ControleColaborador extends Controlador{

        /**
         * Método responsável por mostrar a página inicial do colaborador
         *
         * @return Void.
         *
        **/
        public function colaboradorInicio(){
            $arrFrase = $this->modelo->consultar('frase', '*', array('indAtiva' => 1))[0];
            if(count($arrFrase) > 0){

                $arrUsuario = new ModeloMain(true);
                $arrUsuario = $arrUsuario->getUsuario($arrFrase['cdnUsuario']);
                $this->visualizador->atribuirValor('strFrase', $arrFrase['strFrase']);
                $this->visualizador->atribuirValor('nomAutor', $arrUsuario['nomUsuario']);
            }else{
                $this->visualizador->atribuirValor('strFrase', '');
                $this->visualizador->atribuirValor('nomAutor', '');
            }


            // Cálculo de SMS
            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
            $numLimiteSms = $dtoClinica->getNumLimiteSms();
            $numSmsEnviados = $dtoClinica->getNumEnviosSms();
            $numSmsRecebidos = $dtoClinica->getNumRecebimentosSms();
            $numSms = $numSmsEnviados + $numSmsRecebidos;
            if(($numLimiteSms - $numSms) < 30){
                $this->visualizador->atribuirValor('avisoSms', true);
            }

            
            $this->visualizador->addJs('tema/js/plugins/chartJs/Chart.min.js');
            $this->visualizador->addJs('js/graficoInicio.js');
            $this->visualizador->addJs('js/init.graficoInicio.js');
            
            $this->visualizador->mostrarNaTela('inicio', 'Início');
            return;
        }

        /**
         * Método responsável por mostrar a página de cadastro de colaborador
         *
         * @return Void.
         *
        **/
        public function colaboradorCadastrar(){
            if($this->modelo->master() or $this->modelo->dono()){
                $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Colaborador');
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do colaborador.
         *
         * @return Void.
         *
        **/
        public function colaboradorCadastrarFim(){
            if($this->modelo->master() or $this->modelo->dono()){
                $modColaborador = new ModeloColaborador();
    			$arrValidacao = $modColaborador->colaboradorPreparaDTO();
                $dtoColaborador = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                	$this->visualizador->setFlash($mesErro, 'erro');
                	$this->colaboradorCadastrar();
                	return;
                }

                if($modColaborador->colaboradorCadastrarFim($dtoColaborador)){

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'colaborador', $_POST['strEmail']));

                    $cdnColaborador = $modColaborador->ultimoInserido('colaborador');

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->colaboradorConsultarFim($cdnColaborador);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'colaborador', $_POST['strEmail']));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->colaboradorCadastrar();
                    return;

                }
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um colaborador.
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        */
        public function colaboradorAtualizar($cdnUsuario){
            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->master() or $this->modelo->dono()){
                $modColaborador = new ModeloColaborador();
                if($modColaborador->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)){
                    $modMain = new ModeloMain(true);
                    $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                    $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);
        			$this->visualizador->atribuirValor('dtoColaborador', $modColaborador->getColaborador($cdnUsuario));
        			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar meus dados');
                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * colaborador
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
        **/
        public function colaboradorAtualizarFim($cdnUsuario){
            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->master() or $this->modelo->dono()){
                $modColaborador = new ModeloColaborador();
                if($modColaborador->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)){
					$arrValidacao = $modColaborador->colaboradorPreparaDTO($cdnUsuario);
		            $dtoColaborador = $arrValidacao[0];
		            $dtoColaborador->setCdnUsuario($cdnUsuario);

		            $mesErro = $arrValidacao[1];

		            if($mesErro != ''){
		            	$this->visualizador->setFlash($mesErro, 'erro');
		            	$this->colaboradorAtualizar($cdnUsuario);
		            	return;
		            }


		            if($modColaborador->colaboradorAtualizarFim($dtoColaborador)){

		                // Geração de log
		                $this->log(array('sucesso', 'atualizacao', 'colaborador', $cdnUsuario));

		                $this->visualizador->setFlash(SUCESSO_CADASTRO);
		                $this->colaboradorConsultarFim($cdnUsuario);
                        return;

		            }else{

		                // Geração de log
		                $this->log(array('erro', 'atualizacao', 'colaborador', $cdnUsuario));

		                $this->visualizador->setFlash(ERRO_CADASTRO);
		                $this->colaboradorAtualizar($cdnUsuario);
                        return;

		            }
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por mostrar a lista de colaboradores do sistema
         *
         * @return Void
         *
        **/
        public function colaboradorConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $this->visualizador->atribuirValor('modColaborador', new ModeloColaborador());
            $this->visualizador->atribuirValor('modMain', new ModeloMain(true));
            $this->visualizador->atribuirValor('arrColaboradores', $this->modelo->consultar('colaborador'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Colaboradores');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * colaborador.
         *
         * @param Integer $cdnUsuario - código numérico do colaborador
         * @return Void.
         *
        */
        public function colaboradorConsultarFim($cdnUsuario){
            if($this->modelo->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)){
            	$modColaborador = new ModeloColaborador();
                $dtoColaborador = $modColaborador->getColaborador($cdnUsuario);
                $this->visualizador->atribuirValor('dtoColaborador', $dtoColaborador);
                $this->visualizador->atribuirValor('modColaborador', $modColaborador);

                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario));
                $nomUsuario = $arrUsuario[0]['nomUsuario'];
                $this->visualizador->atribuirValor('arrUsuario', $arrUsuario[0]);

                $this->visualizador->mostrarNaTela('consultarFim', $nomUsuario);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de colaborador
         *
         * @param Integer $cdnUsuario - código numérico do colaborador
         * @return Void.
         *
        **/
        public function colaboradorDeletar($cdnUsuario){
            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono() or $this->modelo->master()){
                $modMain = new ModeloMain(true);
                if($this->modelo->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)){
                    $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                    $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);

                    $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$arrUsuario['nomUsuario']);

                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do colaborador
         *
         * @param Integer $cdnUsuario - código numérico do colaborador
         * @return Void.
         *
        **/
        public function colaboradorDeletarFim($cdnUsuario){
            if($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono() or $this->modelo->master()){
                $modMain = new ModeloMain(true);
                if($this->modelo->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)){
                    $this->modelo->deletar('colaborador', array('cdnUsuario' => $cdnUsuario));
                    $modMain->deletar('usuario', array('cdnUsuario' => $cdnUsuario));
                    if($_SESSION['cdnUsuario'] == $cdnUsuario){
                        $ctrlMain = new ControleMain();
                        $ctrlMain->mainSairFim();
                        return;
                    }
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'colaborador', $cdnUsuario));
                    $this->visualizador->setFlash('Colaborador deletado.', 'sucesso');
                    $this->colaboradorConsultar();
                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

    }
