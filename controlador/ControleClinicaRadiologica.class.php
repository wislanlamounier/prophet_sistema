<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da clínica radiológica
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-14
     *
    **/
    class ControleClinicaRadiologica extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro da clínica radiológica
         *
         * @return Void.
         *
        **/
        public function clinicaRadiologicaCadastrar(){
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Clínica Radiológica');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da clínica radiológica.
         *
         * @return Void.
         *
        **/
        public function clinicaRadiologicaCadastrarFim(){
            $modClinicaRadiologica = new ModeloClinicaRadiologica();
			$arrValidacao = $modClinicaRadiologica->clinicaRadiologicaPreparaDTO();
            $dtoClinicaRadiologica = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->clinicaRadiologicaCadastrar();
            	return;
            }

            if($modClinicaRadiologica->clinicaRadiologicaCadastrarFim($dtoClinicaRadiologica)){

                $cdnClinicaRadiologica = $modClinicaRadiologica->ultimoInserido('clinicaradiologica');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'clinicaradiologica', $cdnClinicaRadiologica));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->clinicaRadiologicaConsultarFim($cdnClinicaRadiologica);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'clinicaradiologica', $_POST['nomClinicaRadiologica']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->clinicaRadiologicaCadastrar();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de uma clínica radiológica.
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Void.
         *
        */
        public function clinicaRadiologicaAtualizar($cdnClinicaRadiologica){
            $modClinicaRadiologica = new ModeloClinicaRadiologica();
            if($modClinicaRadiologica->checaExiste('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica)){
                $dtoClinicaRadiologica = $modClinicaRadiologica->getClinicaRadiologica($cdnClinicaRadiologica);
    			$this->visualizador->atribuirValor('dtoClinicaRadiologica', $dtoClinicaRadiologica);
    			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar '.$dtoClinicaRadiologica->getNomClinicaRadiologica());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * a clínica radiológica
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Void.
         *
        **/
        public function clinicaRadiologicaAtualizarFim($cdnClinicaRadiologica){
            $modClinicaRadiologica = new ModeloClinicaRadiologica();
            if($modClinicaRadiologica->checaExiste('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica)){
				$arrValidacao = $modClinicaRadiologica->clinicaRadiologicaPreparaDTO($cdnClinicaRadiologica);
	            $dtoClinicaRadiologica = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->clinicaRadiologicaAtualizar($cdnClinicaRadiologica);
	            	return;
	            }


	            if($modClinicaRadiologica->clinicaRadiologicaAtualizarFim($dtoClinicaRadiologica)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'clinicaradiologica', $cdnClinicaRadiologica));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->clinicaRadiologicaConsultarFim($cdnClinicaRadiologica);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'clinicaradiologica', $cdnClinicaRadiologica));

	                $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->clinicaRadiologicaAtualizar($cdnClinicaRadiologica);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista da clínica radiológicas do sistema
         *
         * @return Void
         *
        **/
        public function clinicaRadiologicaConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            $modClinicaRadiologica = new ModeloClinicaRadiologica();
            $this->visualizador->atribuirValor('modClinicaRadiologica', $modClinicaRadiologica);
            $this->visualizador->atribuirValor('arrClinicasRadiologicas', $modClinicaRadiologica->consultar('clinicaradiologica'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Clínicas Radiológicas');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * clinicaRadiologica.
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Void.
         *
        */
        public function clinicaRadiologicaConsultarFim($cdnClinicaRadiologica){
            if($this->modelo->checaExiste('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica)){
            	$modClinicaRadiologica = new ModeloClinicaRadiologica();
                $dtoClinicaRadiologica = $modClinicaRadiologica->getClinicaRadiologica($cdnClinicaRadiologica);
                $this->visualizador->atribuirValor('dtoClinicaRadiologica', $dtoClinicaRadiologica);
                $this->visualizador->atribuirValor('modClinicaRadiologica', $modClinicaRadiologica);

                $this->visualizador->mostrarNaTela('consultarFim', $dtoClinicaRadiologica->getNomClinicaRadiologica());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção da clínica radiológica
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Void.
         *
        **/
        public function clinicaRadiologicaDeletar($cdnClinicaRadiologica){
            if($this->modelo->checaExiste('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica)){
                $modClinicaRadiologica = new ModeloClinicaRadiologica();
                $dtoClinicaRadiologica = $modClinicaRadiologica->getClinicaRadiologica($cdnClinicaRadiologica);
                $this->visualizador->atribuirValor('dtoClinicaRadiologica', $dtoClinicaRadiologica);
                $this->visualizador->atribuirValor('cdnClinicaRadiologica', $cdnClinicaRadiologica);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$dtoClinicaRadiologica->getNomClinicaRadiologica());

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da clínica radiológica
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Void.
         *
        **/
        public function clinicaRadiologicaDeletarFim($cdnClinicaRadiologica){
            if($this->modelo->checaExiste('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica)){
                $this->modelo->deletar('clinicaradiologica', array('cdnClinicaRadiologica' => $cdnClinicaRadiologica));
                // Geração de log
                $this->log(array('sucesso', 'delecao', 'clinicaradiologica', $cdnClinicaRadiologica));
                $this->visualizador->setFlash('Clínica radiológica deletada.', 'sucesso');
                $this->clinicaRadiologicaConsultar();
                return;
            }
            $this->erroExistente();
            return;
        }

    }
