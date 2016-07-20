<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da secao
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-17
     *
    **/
    class ControleSecao extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de secao ao usuário
         *
         * @param Integer $cdnProcedimento - código numérico da área de atuação
         * @return Void.
         *
        **/
        public function secaoCadastrar($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                $modProcedimento = new ModeloProcedimento();
                $dtoProcedimento = $modProcedimento->getProcedimento($cdnProcedimento);
                $this->visualizador->atribuirValor('cdnProcedimento', $cdnProcedimento);
                $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Seção em '.$dtoProcedimento->getNomProcedimento());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da secao
         *
         * @param Integer $cdnProcedimento - código numérico da área de atuação
         *
        **/
        public function secaoCadastrarFim($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                $modSecao = new ModeloSecao();
    			$arrValidacao = $modSecao->secaoPreparaDTO();
                $dtoSecao = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                	$this->visualizador->setFlash($mesErro, 'erro');
                	$this->secaoCadastrar($cdnProcedimento);
                	return;
                }

                $dtoSecao->setCdnProcedimento($cdnProcedimento);

                if($modSecao->secaoCadastrarFim($dtoSecao)){

                    $cdnSecao = $modSecao->ultimoInserido('secao');

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'secao', $cdnSecao));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');

                    $ctrlProcedimento = new ControleProcedimento();
                    $ctrlProcedimento->procedimentoConsultarFim($cdnProcedimento);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'secao', ''));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->secaoCadastrar($cdnProcedimento);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de atualização de secao
         *
         * @param Integer $cdnSecao - código numérico da secao
         * @return Void.
         *
        **/
        public function secaoAtualizar($cdnSecao){
            if($this->modelo->checaExiste('secao', 'cdnSecao', $cdnSecao)){
                $modSecao = new ModeloSecao();
                $dtoSecao = $modSecao->getSecao($cdnSecao);
                $this->visualizador->atribuirValor('dtoSecao', $dtoSecao);
                $this->visualizador->atribuirValor('arrSecoes', $modSecao->consultar('secao', '*', array('cdnSecao' => $cdnSecao)));
                $this->visualizador->mostrarNaTela('atualizar', $dtoSecao->getNomSecao());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a atualização da secao
         *
         * @param Integer $cdnSecao - código numérico da secao
         * @return Void.
         *
        **/
        public function secaoAtualizarFim($cdnSecao){
            if($this->modelo->checaExiste('secao', 'cdnSecao', $cdnSecao)){
                $modSecao = new ModeloSecao();

                $arrValidacao = $modSecao->secaoPreparaDTO($cdnSecao);
                $dtoSecao = $arrValidacao[0];

                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->secaoAtualizar($cdnSecao);
                    return;
                }

	            if($modSecao->secaoAtualizarFim($dtoSecao)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'secao', $cdnSecao));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->secaoConsultarFim($cdnSecao);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'secao', $cdnSecao));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->secaoAtualizar($cdnSecao);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * secao.
         *
         * @param Integer $cdnSecao - código numérico da secao
         * @return Void.
         *
        */
        public function secaoConsultarFim($cdnSecao){
            if($this->modelo->checaExiste('secao', 'cdnSecao', $cdnSecao)){
            	$modSecao = new ModeloSecao();
                $dtoSecao = $modSecao->getSecao($cdnSecao);
                $this->visualizador->atribuirValor('dtoSecao', $dtoSecao);
                $this->visualizador->mostrarNaTela('consultarFim', $dtoSecao->getNomSecao());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de seção
         *
         * @param Integer $cdnProcedimento - código numérico da seção
         * @return Void.
         *
        **/
        public function secaoDeletar($cdnSecao){
            if($this->modelo->checaExiste('secao', 'cdnSecao', $cdnSecao)){
                $modSecao = new ModeloSecao();
                $dtoSecao = $modSecao->getSecao($cdnSecao);
                $this->visualizador->atribuirValor('dtoSecao', $dtoSecao);
                $this->visualizador->atribuirValor('cdnSecao', $cdnSecao);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$dtoSecao->getNomSecao());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por desvincular um secao
         *
         * @param Integer $cdnSecao - código numérico da secao
         * @return Void.
         *
        **/
        public function secaoDeletarFim($cdnSecao){
            if($this->modelo->checaExiste('secao', 'cdnSecao', $cdnSecao)){
                $modSecao = new ModeloSecao();
                $dtoSecao = $modSecao->getSecao($cdnSecao);
                $dtoSecao->setIndDesvinculada(1);
                if($modSecao->secaoAtualizarFim($dtoSecao)){
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'secao', $cdnSecao));
                    $this->visualizador->setFlash('Seção deletada com sucesso.', 'sucesso');
                    $ctrlProcedimento = new ControleProcedimento();
                    $ctrlProcedimento->procedimentoConsultarFim($dtoSecao->getCdnProcedimento());
                }else{
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'secao', $cdnSecao));
                    $this->visualizador->setFlash('Um erro ocorreu, por favor tente novemente.', 'aviso');
                    $this->secaoConsultarFim($cdnSecao);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por retornar o select de seções
         *
         * @param Integer $cdnSecao - código numérico do seção para selecionar de início (opcional)
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @param Boolean $label - label a ser colocada. Padrão: Seção.
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param Array $arrSecoes - array de seções a serem mostrados
         * @param String $classe - classe do input. Padrão: iptCdnSecao.
         * @param String $nome - nome do input. Padrão: cdnSecao.
         * @return String - select de seções
         *
        **/
        public function secaoRetornaSelect($cdnSecao = 0, $cdnProcedimento, $label = 'Seção de procedimento', $darEcho = true, $arrSecoes = false, $classe = 'iptCdnSecao', $nome = 'cdnSecao'){
            $modSecao = new ModeloSecao();
            $select = $modSecao->secaoRetornaSelect($cdnSecao, $cdnProcedimento, $label, $arrSecoes, $classe, $nome);
            if($darEcho)
                echo $select;
            return $select;
        }

        /**
         * Método responsável por mostrar um select de seções de uma determinada área de atuação
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Void.
         *
        **/
        public function secaoArea($cdnProcedimento = 0){
            if($cdnProcedimento == 0)
                return false;
            if(isset($_GET['cdnSecao']))
                $cdnSecao = $_GET['cdnSecao'];
            else
                $cdnSecao = 0;
            if($this->modelo->checaExiste('secao', 'cdnProcedimento', $cdnProcedimento))
                $this->secaoRetornaSelect($cdnSecao, $cdnProcedimento);
        }

        /**
         * Método responsável por avisar quando foi a última consulta do paciente nesta seção
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function secaoAviso($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modSecao = new ModeloSecao();
                $arrCond = array('indAviso' => 1,
                                 'conscond1' => 'AND',
                                 'indDesvinculada' => 0);
                $modConsulta = new ModeloConsulta();
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                $arrSecoes = $this->modelo->consultar('secao', '*', $arrCond);
                foreach($arrSecoes as $arrSecao){
                    $dtoSecao = $modSecao->getSecao($arrSecao['cdnSecao']);
                    if($dtoSecao->getIndAviso()){
                        $arrCond = array('cdnSecao'    => $dtoSecao->getCdnSecao(),
                                         'conscond1'   => 'AND',
                                         'cdnPaciente' => $cdnPaciente);
                        $arrConsultas = $this->modelo->consultar('consulta', '*', $arrCond);
                        if(count($arrConsultas) > 0){
                            $arrConsulta = $arrConsultas[count($arrConsultas) - 1];
                            $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                            echo 'Último '.$dtoSecao->getNomSecao().': '.$dtoConsulta->getDatConsulta(true).'.<br>';
                        }else{
                            $link = $this->visualizador->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($cdnPaciente), '_blank');
                            echo $link.' nunca realizou '.$dtoSecao->getNomSecao().'.<br>';
                        }
                    }
                }
            }
        }
    }


