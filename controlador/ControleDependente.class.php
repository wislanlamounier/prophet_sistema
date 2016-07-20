<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do dependente
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-27
     *
    **/
    class ControleDependente extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de dependente
         *
         * @param Integer $cdnResponsavel - código numérico do responsável.
         * @return Void.
         *
        **/
        public function dependenteCadastrar($cdnResponsavel){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnResponsavel)){
                $ctrlPaciente = new ControlePaciente();
                $this->visualizador->atribuirValor('selectPaciente', $ctrlPaciente->pacienteRetornaSelect(0, 'Selecione o paciente', false));
                $this->visualizador->atribuirValor('cdnResponsavel', $cdnResponsavel);
                $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Dependente');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do dependente.
         *
         * @param Integer $cdnResponsavel - código numérico do responsável.
         * @return Void.
         *
        **/
        public function dependenteCadastrarFim($cdnResponsavel){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnResponsavel)){
                $modDependente = new ModeloDependente();
    			$arrValidacao = $modDependente->dependentePreparaDTO($cdnResponsavel, $indParceria);
                $dtoDependente = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                	$this->visualizador->setFlash($mesErro, 'erro');
                	$this->dependenteCadastrar();
                	return;
                }

                if($modDependente->dependenteCadastrarFim($dtoDependente)){

                    $cdnDependente = $modDependente->ultimoInserido('dependente');

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'dependente', $cdnDependente));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $ctrlPaciente->pacienteConsultarFim($dtoDependente->getCdnResponsavel());
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'dependente', $_POST['nomDependente']));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->dependenteCadastrar($cdnResponsavel, $indParceria);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de dependente
         *
         * @param Integer $cdnDependente - código numérico do dependente
         * @return Void.
         *
        **/
        public function dependenteDeletar($cdnDependente){
            if($this->modelo->checaExiste('dependente', 'cdnDependente', $cdnDependente)){
                $modDependente = new ModeloDependente();
                $dtoDependente = $modDependente->getDependente($cdnDependente);

                $this->visualizador->atribuirValor('cdnPaciente', $dtoDependente->getCdnPaciente());
                $this->visualizador->atribuirValor('cdnDependente', $cdnDependente);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar dependente');

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do dependente
         *
         * @param Integer $cdnDependente - código numérico do dependente
         * @return Void.
         *
        **/
        public function dependenteDeletarFim($cdnDependente){
            if($this->modelo->checaExiste('dependente', 'cdnDependente', $cdnDependente)){
                $modDependente = new ModeloDependente();
                $dtoDependente = $modDependente->getDependente($cdnDependente);

                $this->visualizador->setFlash('Dependente deletado.', 'sucesso');
                
                $this->modelo->deletar('dependente', array('cdnDependente' => $cdnDependente));
                
                $ctrlPaciente = new ControlePaciente();
                $ctrlPaciente->pacienteConsultarFim($dtoDependente->getCdnResponsavel());
                return;
            }
            $this->erroExistente();
            return;
        }

    }
