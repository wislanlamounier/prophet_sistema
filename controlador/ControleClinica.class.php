<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do clinica
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-11
     *
    **/
    class ControleClinica extends Controlador{

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um clinica.
         *
         * @return Void.
         *
        */
        public function clinicaAtualizar(){
            if(isset($_SESSION['cdnClinica']))
                $cdnClinica = $_SESSION['cdnClinica'];
            else
                $this->inicio();

            if($this->modelo->master()){
                $modClinica = new ModeloClinica(true);
                if($modClinica->checaExiste('clinica', 'cdnClinica', $cdnClinica)){
        			$this->visualizador->atribuirValor('dtoClinica', $modClinica->getClinica($cdnClinica));
        			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar dados da clínica');
                    return;
                }
                $this->erroExiste();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * clinica
         *
         * @return Void.
         *
        **/
        public function clinicaAtualizarFim(){
            if(isset($_SESSION['cdnClinica']))
                $cdnClinica = $_SESSION['cdnClinica'];
            else
                $this->inicio();

            if($this->modelo->master()){
                $modClinica = new ModeloClinica(true);
                if($modClinica->checaExiste('clinica', 'cdnClinica', $cdnClinica)){
					$arrValidacao = $modClinica->clinicaPreparaDTO($cdnClinica);
		            $dtoClinica = $arrValidacao[0];
		            $dtoClinica->setCdnClinica($cdnClinica);

		            $mesErro = $arrValidacao[1];

		            if($mesErro != ''){
		            	$this->visualizador->setFlash($mesErro, 'erro');
		            	$this->clinicaAtualizar($cdnClinica);
		            	return;
		            }


		            if($modClinica->clinicaAtualizarFim($dtoClinica)){

		                // Geração de log
		                $this->log(array('sucesso', 'atualizacao', 'clinica', $cdnClinica));

		                $this->visualizador->setFlash(SUCESSO_CADASTRO);
		                $this->clinicaConsultarFim($cdnClinica);
                        return;

		            }else{

		                // Geração de log
		                $this->log(array('erro', 'atualizacao', 'clinica', $cdnClinica));

		                $this->visualizador->setFlash(ERRO_CADASTRO);
		                $this->clinicaAtualizar($cdnClinica);
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
         * Método responsável por mostrar o perfil de um
         * clinica.
         *
         * @return Void.
         *
        */
        public function clinicaConsultarFim(){
            if(isset($_SESSION['cdnClinica']))
                $cdnClinica = $_SESSION['cdnClinica'];
            else
                $this->inicio();

            $modClinica = new ModeloClinica(true);
            if($modClinica->checaExiste('clinica', 'cdnClinica', $cdnClinica)){
                $dtoClinica = $modClinica->getClinica($cdnClinica);
                $this->visualizador->atribuirValor('dtoClinica', $dtoClinica);

                $this->visualizador->mostrarNaTela('consultarFim', $dtoClinica->getNomClinica());
                return;
            }
            $this->erroExistente();
            return;
        }


        /**
         * Método responsável por mostrar a página de abrir/fechar os prontuários
         *
         * @return Void.
         *
        **/
        public function clinicaDisponivel(){
            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
            $this->visualizador->atribuirValor('indProntuario', $dtoClinica->getIndProntuario());
            $this->visualizador->mostrarNaTela('disponivel', 'Status de prontuário');
        }

        /**
         * Método responsável por finalizar a abertura/fechamento dos prontuários
         *
         * @return Void.
         *
        **/
        public function clinicaDisponivelFim($indProntuario){
            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
            $dtoClinica->setIndProntuario($indProntuario);



            if($modClinica->clinicaAtualizarFim($dtoClinica)){
                if($indProntuario)
                    $this->visualizador->setFlash('Prontuários disponíveis.', 'sucesso');
                else
                    $this->visualizador->setFlash('Prontuários fechados.', 'sucesso');
            }else{
                $this->visualizador->setFlash('Ocorreu um problema. Por favor, tente novamente.', 'erro');
            }

            $this->log(array('sucesso', 'disponibilidade', 'prontuario', $indProntuario));

            $this->inicio();
            return;
        }


        /**
         * Método responsável por realizar a verificação da necessidade de impressão de prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function clinicaProntuarioAviso($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modProntuario = new ModeloProntuario();
                $modProntuario->prontuarioAviso($cdnPaciente);
            }
        }

    }
