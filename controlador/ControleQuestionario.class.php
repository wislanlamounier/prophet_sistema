<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do questionario
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-31
     *
    **/
    class ControleQuestionario extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de pergunta em questionário
         *
         * @return Void.
         *
        **/
        public function questionarioCadastrarPergunta(){
            $this->visualizador->mostrarNaTela('cadastrarPergunta', 'Cadastrar Pergunta');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do questionario.
         *
         * @return Void.
         *
        **/
        public function questionarioCadastrarPerguntaFim(){
            $modPergunta = new ModeloPergunta();
			$arrValidacao = $modPergunta->perguntaPreparaDTO();
            $dtoPergunta = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->questionarioCadastrarPergunta();
            	return;
            }

            if($modPergunta->perguntaCadastrarFim($dtoPergunta)){

                $cdnPergunta = $modPergunta->ultimoInserido('pergunta');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'pergunta', $cdnPergunta));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->questionarioConsultarPergunta($cdnPergunta);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'pergunta', $_POST['strPergunta']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->questionarioCadastrarPergunta();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de uma pergunta.
         *
         * @param Integer $cdnPergutna - código numérico da pergunta
         * @return Void.
         *
        */
        public function questionarioAtualizarPergunta($cdnPergunta){
            $modPergunta = new ModeloPergunta();
            if($modPergunta->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
                $dtoPergunta = $modPergunta->getPergunta($cdnPergunta);
    			$this->visualizador->atribuirValor('dtoPergunta', $dtoPergunta);
    			$this->visualizador->mostrarNaTela('atualizarPergunta', 'Atualizar pergunta');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * pergunta
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Void.
         *
        **/
        public function questionarioAtualizarPerguntaFim($cdnPergunta){
            $modPergunta = new ModeloPergunta();
            if($modPergunta->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
				$arrValidacao = $modPergunta->perguntaPreparaDTO($cdnPergunta);
	            $dtoPergunta = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->questionarioAtualizarPergunta($cdnPergunta);
	            	return;
	            }


	            if($modPergunta->perguntaAtualizarFim($dtoPergunta)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'pergunta', $cdnPergunta));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->questionarioConsultarPergunta($cdnPergunta);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'pergunta', $cdnPergunta));

	                $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->questionarioAtualizarPergunta($cdnPergunta);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de perguntas do sistema
         *
         * @return Void
         *
        **/
        public function questionarioConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            $modPergunta = new ModeloPergunta();
            $this->visualizador->atribuirValor('modPergunta', $modPergunta);
            $this->visualizador->atribuirValor('arrPerguntas', $modPergunta->consultar('pergunta'));
            $this->visualizador->mostrarNaTela('consultar', 'Questionário de saúde');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de uma
         * pergunta.
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Void.
         *
        */
        public function questionarioConsultarPergunta($cdnPergunta){
            if($this->modelo->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');


            	$modPergunta = new ModeloPergunta();
                $dtoPergunta = $modPergunta->getPergunta($cdnPergunta);
                $this->visualizador->atribuirValor('dtoPergunta', $dtoPergunta);
                $this->visualizador->atribuirValor('modPergunta', $modPergunta);

                if($this->modelo->checaExiste('pergunta_opcao', 'cdnPergunta', $cdnPergunta)){
                    $arrCond = array('cdnPergunta' => $cdnPergunta);
                    $this->visualizador->atribuirValor('arrOpcoes', $this->modelo->consultar('pergunta_opcao', '*', $arrCond));
                }

                $this->visualizador->mostrarNaTela('consultarPergunta', 'Pergunta de Questionário de Saúde');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de pergunta
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Void.
         *
        **/
        public function questionarioDeletarPergunta($cdnPergunta){
            if($this->modelo->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
                $this->visualizador->atribuirValor('cdnPergunta', $cdnPergunta);
                $this->visualizador->mostrarNaTela('deletarPergunta', 'Deletar pergunta');

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da pergunta
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Void.
         *
        **/
        public function questionarioDeletarPerguntaFim($cdnPergunta){
            if($this->modelo->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
                $this->modelo->deletar('pergunta', array('cdnPergunta' => $cdnPergunta));
                
                $this->visualizador->setFlash('Pergunta deletada.', 'sucesso');
                $this->questionarioConsultar();
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de escolha de campos que serão impressos
         *
        **/
        public function questionarioVisualizacao(){
            $this->visualizador->atribuirValor('modelo', new Modelo());
            $arrCond = array('indMostrar' => 1);
            $sql = 'SELECT * FROM schema_campo WHERE nomCampo != "nomPaciente" AND
                                                     nomCampo != "nomSobrenome" AND
                                                     nomCampo != "codCpf" AND
                                                     nomCampo != "codCnpj" AND
                                                     nomCampo != "codCpfCnpj" AND
                                                     nomCampo != "datNascimento" AND
                                                     nomCampo != "numTelefones" AND
                                                     nomCampo != "numTelefone1" AND
                                                     nomCampo != "numTelefone2" AND
                                                     nomCampo != "numTelefone3" AND
                                                     indMostrar = 1 AND
                                                     cdnPai = 0 AND
                                                     indTipo != "file" AND
                                                     nomTabela = "paciente"';
            $this->visualizador->atribuirValor('arrCampos', $this->modelo->query($sql));

            $this->visualizador->mostrarNaTela('visualizacao', 'Campos impressos');
        }

        /**
         * Método responsável por atualizar os campos que serão impressos
         *
        **/
        public function questionarioVisualizacaoAtualizar(){
            $this->modelo->sql('DELETE FROM anamnese_campo WHERE 1');

            foreach($_POST as $cdnCampo=>$valCampo){
                $this->modelo->inserir('anamnese_campo', array('cdnCampo' => $cdnCampo));
            }

            $this->visualizador->setFlash('Campos atualizados com sucesso.', 'sucesso');
            $this->questionarioVisualizacao();
            
        }

        /**
         * Método responsável por mostrar a página de cadastro de opção em uma pergunta
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Void.
         *
        **/
        public function questionarioCadastrarOpcao($cdnPergunta){
            if($this->modelo->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
                $modPergunta = new ModeloPergunta();
                $dtoPergunta = $modPergunta->getPergunta($cdnPergunta);

                $this->visualizador->atribuirValor('cdnPergunta', $cdnPergunta);
                $this->visualizador->atribuirValor('strPergunta', $dtoPergunta->getStrPergunta());
                $this->visualizador->mostrarNaTela('cadastrarOpcao', 'Cadastrar opção de resposta');
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da opção de resposta
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Void.
         *
        **/
        public function questionarioCadastrarOpcaoFim($cdnPergunta){
            if($this->modelo->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta)){
                $modPergunta = new ModeloPergunta();
                $arrValidacao = $modPergunta->perguntaOpcaoPreparaDTO();
                $dtoOpcao = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->questionarioCadastrarOpcao($cdnPergunta);
                    return;
                }

                $dtoOpcao->setCdnPergunta($cdnPergunta);

                if($modPergunta->perguntaOpcaoCadastrarFim($dtoOpcao)){

                    $cdnOpcao = $modPergunta->ultimoInserido('pergunta_opcao');

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'pergunta_opcao', $cdnOpcao));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->questionarioConsultarPergunta($cdnPergunta);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'pergunta_opcao', $_POST['strOpcao']));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->questionarioCadastrarOpcao($cdnPergunta);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }


        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de uma opção.
         *
         * @param Integer $cdnOpcao - código numérico da opção
         * @return Void.
         *
        */
        public function questionarioAtualizarOpcao($cdnOpcao){
            $modPergunta = new ModeloPergunta();
            if($modPergunta->checaExiste('pergunta_opcao', 'cdnOpcao', $cdnOpcao)){
                $dtoOpcao = $modPergunta->getOpcao($cdnOpcao);

                $modPergunta = new ModeloPergunta();
                $dtoPergunta = $modPergunta->getPergunta($dtoOpcao->getCdnPergunta());

                $this->visualizador->atribuirValor('strPergunta', $dtoPergunta->getStrPergunta());
                $this->visualizador->atribuirValor('dtoOpcao', $dtoOpcao);
                $this->visualizador->mostrarNaTela('atualizarOpcao', 'Atualizar opção de resposta');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * opção
         *
         * @param Integer $cdnOpcao - código numérico da opção
         * @return Void.
         *
        **/
        public function questionarioAtualizarOpcaoFim($cdnOpcao){
            $modPergunta = new ModeloPergunta();
            if($modPergunta->checaExiste('pergunta_opcao', 'cdnOpcao', $cdnOpcao)){
                $arrValidacao = $modPergunta->perguntaOpcaoPreparaDTO($cdnOpcao);
                $dtoOpcao = $arrValidacao[0];

                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->questionarioAtualizarOpcao($cdnOpcao);
                    return;
                }

                $cdnPergunta = $dtoOpcao->getCdnPergunta();

                if($modPergunta->perguntaOpcaoAtualizarFim($dtoOpcao)){

                    // Geração de log
                    $this->log(array('sucesso', 'atualizacao', 'pergunta_opcao', $cdnOpcao));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO);
                    $this->questionarioConsultarPergunta($cdnPergunta);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'atualizacao', 'pergunta_opcao', $cdnOpcao));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
                    $this->questionarioAtualizarPergunta($cdnPergunta);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de opção
         *
         * @param Integer $cdnOpcao - código numérico da opção
         * @return Void.
         *
        **/
        public function questionarioDeletarOpcao($cdnOpcao){
            if($this->modelo->checaExiste('pergunta_opcao', 'cdnOpcao', $cdnOpcao)){

                $modPergunta = new ModeloPergunta();
                $dtoOpcao = $modPergunta->getOpcao($cdnOpcao);

                $this->visualizador->atribuirValor('cdnPergunta', $dtoOpcao->getCdnPergunta());
                $this->visualizador->atribuirValor('cdnOpcao', $cdnOpcao);
                $this->visualizador->mostrarNaTela('deletarOpcao', 'Deletar opção de resposta');

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da opção
         *
         * @param Integer $cdnOpcao - código numérico da opção
         * @return Void.
         *
        **/
        public function questionarioDeletarOpcaoFim($cdnOpcao){
            if($this->modelo->checaExiste('pergunta_opcao', 'cdnOpcao', $cdnOpcao)){
                $modPergunta = new ModeloPergunta();
                $dtoOpcao = $modPergunta->getOpcao($cdnOpcao);
                $this->modelo->deletar('pergunta_opcao', array('cdnOpcao' => $cdnOpcao));
                
                $this->visualizador->setFlash('Opção de resposta deletada.', 'sucesso');
                $this->questionarioConsultarPergunta($dtoOpcao->getCdnPergunta());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por imprimir o questionário
         *
        **/
        public function questionarioImprimir(){
            $modPergunta = new ModeloPergunta();
            $modPergunta->perguntaImprimirQuestionario();
        }
    }