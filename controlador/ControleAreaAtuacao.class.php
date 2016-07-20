<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da area de atuação
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-15
     *
    **/
    class ControleAreaAtuacao extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de área de atuação
         *
         * @return Void.
         *
        **/
        public function areaAtuacaoCadastrar(){
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Área de Atuação');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do areaAtuacao.
         *
         * @return Void.
         *
        **/
        public function areaAtuacaoCadastrarFim(){
            $modAreaAtuacao = new ModeloAreaAtuacao();
			$arrValidacao = $modAreaAtuacao->areaAtuacaoPreparaDTO();
            $dtoAreaAtuacao = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->areaAtuacaoCadastrar();
            	return;
            }

            if($modAreaAtuacao->areaAtuacaoCadastrarFim($dtoAreaAtuacao)){

                $cdnAreaAtuacao = $modAreaAtuacao->ultimoInserido('areaatuacao');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'areaatuacao', $cdnAreaAtuacao));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->areaAtuacaoConsultarFim($cdnAreaAtuacao);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'areaatuacao', $_POST['nomAreaAtuacao']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->areaAtuacaoCadastrar();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de uma área de atuação.
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        */
        public function areaAtuacaoAtualizar($cdnAreaAtuacao){
            $modAreaAtuacao = new ModeloAreaAtuacao();
            if($modAreaAtuacao->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
    			$this->visualizador->atribuirValor('dtoAreaAtuacao', $dtoAreaAtuacao);

    			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar '.$dtoAreaAtuacao->getNomAreaAtuacao());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * a área de atuação
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        **/
        public function areaAtuacaoAtualizarFim($cdnAreaAtuacao){
            $modAreaAtuacao = new ModeloAreaAtuacao();
            if($modAreaAtuacao->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
				$arrValidacao = $modAreaAtuacao->areaAtuacaoPreparaDTO($cdnAreaAtuacao);
	            $dtoAreaAtuacao = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->areaAtuacaoAtualizar($cdnAreaAtuacao);
	            	return;
	            }

	            if($modAreaAtuacao->areaAtuacaoAtualizarFim($dtoAreaAtuacao)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'areaatuacao', $cdnAreaAtuacao));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->areaAtuacaoConsultarFim($cdnAreaAtuacao);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'areaatuacao', $cdnAreaAtuacao));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->areaAtuacaoAtualizar($cdnAreaAtuacao);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de áreas de atuação do sistema
         *
         * @return Void
         *
        **/
        public function areaAtuacaoConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            $modAreaAtuacao = new ModeloAreaAtuacao();
            $this->visualizador->atribuirValor('modAreaAtuacao', $modAreaAtuacao);
            $this->visualizador->atribuirValor('arrAreaAtuacoes', $modAreaAtuacao->consultar('areaatuacao', '*', array('indDesvinculada' => 0), 'nomAreaAtuacao'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Áreas de Atuação');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de uma
         * área de atuação.
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        */
        public function areaAtuacaoConsultarFim($cdnAreaAtuacao){
            if($this->modelo->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
            	$modAreaAtuacao = new ModeloAreaAtuacao();
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
                $this->visualizador->atribuirValor('dtoAreaAtuacao', $dtoAreaAtuacao);
                $this->visualizador->atribuirValor('modAreaAtuacao', $modAreaAtuacao);
                $arrCond = array('cdnAreaAtuacao' => $cdnAreaAtuacao,
                                 'conscond1' => 'AND',
                                 'indDesvinculado' => 0);
                $this->visualizador->atribuirValor('arrProcedimentos', $this->modelo->consultar('procedimento', '*', $arrCond));
                $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());
                $this->visualizador->mostrarNaTela('consultarFim', $dtoAreaAtuacao->getNomAreaAtuacao());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de área de atuação
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        **/
        public function areaAtuacaoDeletar($cdnAreaAtuacao){
            if($this->modelo->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
                $modAreaAtuacao = new ModeloAreaAtuacao();
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
                $this->visualizador->atribuirValor('dtoAreaAtuacao', $dtoAreaAtuacao);
                $this->visualizador->atribuirValor('cdnAreaAtuacao', $cdnAreaAtuacao);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$dtoAreaAtuacao->getNomAreaAtuacao());

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da área de atuação
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        **/
        public function areaAtuacaoDeletarFim($cdnAreaAtuacao){
            if($this->modelo->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
                $modAreaAtuacao = new ModeloAreaAtuacao();
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
                $dtoAreaAtuacao->setIndDesvinculada(1);
                if($modAreaAtuacao->areaAtuacaoAtualizarFim($dtoAreaAtuacao)){
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'areaatuacao', $cdnAreaAtuacao));
                    $this->visualizador->setFlash('Área de atuação deletada.', 'sucesso');
                    $this->areaAtuacaoConsultar();
                }else{
                    // Geração de log
                    $this->log(array('erro', 'atualizacao', 'areaatuacao', $cdnAreaAtuacao));
                    $this->visualizador->setFlash('Um erro ocorreu, por favor tente novemente.', 'aviso');
                    $this->areaAtuacaoConsultarFim($cdnAreaAtuacao);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por retornar um select de áreas de atuação.
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área para selecionar de início (opcional)
         * @param String $label - label. Padrão: Área de Atuação
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param Array $arrAreasAtuacoes - áreas de atuações escolhidas para o select
         * @param String $classe - classe do input. Padrão: iptCdnAreaAtuacao.
         * @param String $nome - nome do input. Padrão: cdnAreaAtuacao.
         *
         * @return String - select de áreas de atuação
         *
        **/
        public function areaAtuacaoRetornaSelect($cdnAreaAtuacao = 0, $label = 'Área de Atuação', $darEcho = true, $arrAreasAtuacoes = false, $classe = 'iptCdnAreaAtuacao', $nome = 'cdnAreaAtuacao'){
            $modAreaAtuacao = new ModeloAreaAtuacao();
            $select = $modAreaAtuacao->areaAtuacaoRetornaSelect($cdnAreaAtuacao, $label, $arrAreasAtuacoes, $classe, $nome);
            if($darEcho)
                echo $select;
            return $select;
        }

        /**
         * Método responsável por montar um select de áreas de atuação baseando-se na
         * área de atuação de um dentista
         *
         * @param Integer $cdnDentista - código númérico do dentista.
         * @return String - select de áreas de atuação.
         *
        **/
        public function areaAtuacaoDentista($cdnDentista, $darEcho = true){
            if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                $sqlRel = 'SELECT cdnAreaAtuacao FROM dentista_areaatuacao WHERE cdnDentista = '.$cdnDentista;
                $sql = 'SELECT * FROM areaatuacao WHERE cdnAreaAtuacao IN ('.$sqlRel.')';

                $modAreaAtuacao = new ModeloAreaAtuacao();
                $arrAreasAtuacoes = $modAreaAtuacao->query($sql);
                return $this->areaAtuacaoRetornaSelect(0, 'Área de atuação', true, $arrAreasAtuacoes);
            }
        }

        /**
         * Método responsável por adicionar um procedimento na área de vínculo
         *
         * @param Integer $qtdProcedimentos - quantidade de procedimentos que estão na div + 1
         *
        **/
        public function areaAtuacaoAdicionarProcedimento($qtdProcedimentos){

            $div = '<div class="procedimento" id="procedimento'.$qtdProcedimentos.'">';

            $div .= '<div class="col-md-11 form-group">';
            $div .= '<label id="lblNomProcedimento'.$qtdProcedimentos.'" for="nomProcedimento'.$qtdProcedimentos.'" class="control-label">Procedimento '.$qtdProcedimentos.'</label>';
            $div .= '<input required type="text" id="iptNomProcedimento'.$qtdProcedimentos.'" name="nomProcedimento'.$qtdProcedimentos.'" class="form-control">';
            $div .= '</div>';

            $div .= '<div class="col-md-1 form-group"><br>';
            $div .= '<button type="button" class="btn btn-default btn-lg btnRemover" id="'.$qtdProcedimentos.'">';
            $div .= '<span class="fa fa-remove"></span>';
            $div .= '</button>';
            $div .= '</div>';

            $div .= '</div>';
            echo $div;
        }

    }
