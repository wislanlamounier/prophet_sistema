<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do procedimento
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-16
     *
    **/
    class ControleProcedimento extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de procedimento ao usuário
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        **/
        public function procedimentoCadastrar($cdnAreaAtuacao){
            if($this->modelo->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
                // Tabelas de preço
                $sql = 'select * from parceria pa inner join parceria_preco pe on pa.cdnParceria = pe.cdnParceria 
                        group by pa.cdnParceria';
                $arrParcerias = $this->modelo->query($sql);
                $arrTabelas = $this->modelo->consultar('tabelapreco');
                $this->visualizador->atribuirValor('arrTabelas', $arrTabelas);
                $this->visualizador->atribuirValor('arrParcerias', $arrParcerias);
                $this->visualizador->atribuirValor('modParceria', new ModeloParceria());
                $this->visualizador->atribuirValor('modTabelaPreco', new ModeloTabelaPreco());

                $modAreaAtuacao = new ModeloAreaAtuacao();
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
                $this->visualizador->atribuirValor('cdnAreaAtuacao', $cdnAreaAtuacao);
                $this->visualizador->addJs('js/procedimentoCadastrar.js');
                $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Procedimento em '.$dtoAreaAtuacao->getNomAreaAtuacao());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do procedimento
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         *
        **/
        public function procedimentoCadastrarFim($cdnAreaAtuacao){
            if($this->modelo->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao)){
                $modProcedimento = new ModeloProcedimento();
    			$arrValidacao = $modProcedimento->procedimentoPreparaDTO();
                $dtoProcedimento = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                	$this->visualizador->setFlash($mesErro, 'erro');
                	$this->procedimentoCadastrar($cdnAreaAtuacao);
                	return;
                }

                $dtoProcedimento->setCdnAreaAtuacao($cdnAreaAtuacao);

                if($modProcedimento->procedimentoCadastrarFim($dtoProcedimento)){

                    $cdnProcedimento = $modProcedimento->ultimoInserido('procedimento');

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'procedimento', $cdnProcedimento));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->procedimentoConsultarFim($cdnProcedimento);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'procedimento', ''));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->procedimentoCadastrar($cdnAreaAtuacao);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de atualização de procedimento
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Void.
         *
        **/
        public function procedimentoAtualizar($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                // Tabelas de preço
                $arrTabelas = $this->modelo->consultar('tabelapreco_procedimento', '*', array('cdnProcedimento' => $cdnProcedimento));
                $arrParcerias = $this->modelo->consultar('parceria_preco', '*', array('cdnProcedimento' => $cdnProcedimento));
                $this->visualizador->atribuirValor('arrTabelas', $arrTabelas);
                $this->visualizador->atribuirValor('arrParcerias', $arrParcerias);
                $this->visualizador->atribuirValor('modParceria', new ModeloParceria());
                $this->visualizador->atribuirValor('modTabelaPreco', new ModeloTabelaPreco());

                $modProcedimento = new ModeloProcedimento();
                $dtoProcedimento = $modProcedimento->getProcedimento($cdnProcedimento);
                $this->visualizador->atribuirValor('dtoProcedimento', $dtoProcedimento);
                $this->visualizador->atribuirValor('arrSecoes', $modProcedimento->consultar('secao', '*', array('cdnProcedimento' => $cdnProcedimento)));
                $this->visualizador->mostrarNaTela('atualizar', $dtoProcedimento->getNomProcedimento());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a atualização do procedimento
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Void.
         *
        **/
        public function procedimentoAtualizarFim($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                $modProcedimento = new ModeloProcedimento();

                $arrValidacao = $modProcedimento->procedimentoPreparaDTO($cdnProcedimento);
                $dtoProcedimento = $arrValidacao[0];

                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->procedimentoAtualizar($cdnProcedimento);
                    return;
                }

	            if($modProcedimento->procedimentoAtualizarFim($dtoProcedimento)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'procedimento', $cdnProcedimento));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->procedimentoConsultarFim($cdnProcedimento);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'procedimento', $cdnProcedimento));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->procedimentoAtualizar($cdnProcedimento);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * procedimento.
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Void.
         *
        */
        public function procedimentoConsultarFim($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            	$modProcedimento = new ModeloProcedimento();
                $dtoProcedimento = $modProcedimento->getProcedimento($cdnProcedimento);
                $this->visualizador->atribuirValor('dtoProcedimento', $dtoProcedimento);
                $this->visualizador->atribuirValor('modProcedimento', $modProcedimento);
                $arrCond = array('cdnProcedimento' => $cdnProcedimento,
                                 'conscond1' => 'AND',
                                 'indDesvinculada' => 0);
                $this->visualizador->atribuirValor('arrSecoes', $this->modelo->consultar('secao', '*', $arrCond));
                $this->visualizador->atribuirValor('modSecao', new ModeloSecao());

                // Tabelas de preço
                $arrTabelas = $this->modelo->consultar('tabelapreco_procedimento', '*', array('cdnProcedimento' => $cdnProcedimento));
                $arrParcerias = $this->modelo->consultar('parceria_preco', '*', array('cdnProcedimento' => $cdnProcedimento));
                $this->visualizador->atribuirValor('arrTabelas', $arrTabelas);
                $this->visualizador->atribuirValor('arrParcerias', $arrParcerias);
                $this->visualizador->atribuirValor('modParceria', new ModeloParceria());
                $this->visualizador->atribuirValor('modTabelaPreco', new ModeloTabelaPreco());

                $this->visualizador->mostrarNaTela('consultarFim', $dtoProcedimento->getNomProcedimento());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de procedimento
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Void.
         *
        **/
        public function procedimentoDeletar($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                $modProcedimento = new ModeloProcedimento();
                $dtoProcedimento = $modProcedimento->getProcedimento($cdnProcedimento);
                $this->visualizador->atribuirValor('dtoProcedimento', $dtoProcedimento);
                $this->visualizador->atribuirValor('cdnProcedimento', $cdnProcedimento);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$dtoProcedimento->getNomProcedimento());

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por desvincular um procedimento
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Void.
         *
        **/
        public function procedimentoDeletarFim($cdnProcedimento){
            if($this->modelo->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento)){
                $modProcedimento = new ModeloProcedimento();
                $dtoProcedimento = $modProcedimento->getProcedimento($cdnProcedimento);
                $dtoProcedimento->setIndDesvinculado(1);
                if($modProcedimento->procedimentoAtualizarFim($dtoProcedimento)){
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'procedimento', $cdnProcedimento));
                    $this->visualizador->setFlash('Procedimento deletado com sucesso.', 'sucesso');
                    $ctrlAreaAtuacao = new ControleAreaAtuacao();
                    $ctrlAreaAtuacao->areaAtuacaoConsultarFim($dtoProcedimento->getCdnAreaAtuacao());
                }else{
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'procedimento', $cdnProcedimento));
                    $this->visualizador->setFlash('Um erro ocorreu, por favor tente novemente.', 'aviso');
                    $this->procedimentoConsultarFim($cdnProcedimento);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por retornar o select de procedimentos
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento para selecionar de início (opcional)
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @param Boolean $label - label a ser colocada. Padrão: Procedimento.
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param Array $arrProcedimentos - array de procedimentos a serem mostrados
         * @param String $classe - classe do input. Padrão: iptCdnProcedimento.
         * @param String $nome - nome do input. Padrão: cdnProcedimento.
         * @return String - select de procedimentos
         *
        **/
        public function procedimentoRetornaSelect($cdnProcedimento = 0, $cdnAreaAtuacao, $label = 'Procedimento', $darEcho = true, $arrProcedimentos = false, $classe = 'iptCdnProcedimento', $nome = 'cdnProcedimento'){
            $modProcedimento = new ModeloProcedimento();
            $select = $modProcedimento->procedimentoRetornaSelect($cdnProcedimento, $cdnAreaAtuacao, $label, $arrProcedimentos, $classe, $nome);
            if($darEcho)
                echo $select;
            return $select;
        }

        /**
         * Método responsável por mostrar um select de procedimentos de uma determinada área de atuação
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
        **/
        public function procedimentoArea($cdnAreaAtuacao){
            if(isset($_GET['cdnProcedimento']))
                $cdnProcedimento = $_GET['cdnProcedimento'];
            else
                $cdnProcedimento = 0;

            $this->procedimentoRetornaSelect($cdnProcedimento, $cdnAreaAtuacao);
        }

        /**
         * Método responsável por avisar quando foi a última consulta do paciente neste procedimento
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function procedimentoAviso($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modProcedimento = new ModeloProcedimento();
                $arrCond = array('indAviso' => 1,
                                 'conscond1' => 'AND',
                                 'indDesvinculado' => 0);
                $modConsulta = new ModeloConsulta();
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                $arrProcedimentos = $this->modelo->consultar('procedimento', '*', $arrCond);
                foreach($arrProcedimentos as $arrProcedimento){
                    $dtoProcedimento = $modProcedimento->getProcedimento($arrProcedimento['cdnProcedimento']);
                    if($dtoProcedimento->getIndAviso()){
                        $arrCond = array('cdnProcedimento' => $dtoProcedimento->getCdnProcedimento(),
                                         'conscond1'       => 'AND',
                                         'cdnPaciente'     => $cdnPaciente);
                        $arrConsultas = $this->modelo->consultar('consulta', '*', $arrCond);
                        if(count($arrConsultas) > 0){
                            $arrConsulta = $arrConsultas[count($arrConsultas) - 1];
                            $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                            echo 'Último '.$dtoProcedimento->getNomProcedimento().': '.$dtoConsulta->getDatConsulta(true).'.<br>';
                        }else{
                            $link = $this->visualizador->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($cdnPaciente), '_blank');
                            echo $link.' nunca realizou '.$dtoProcedimento->getNomProcedimento().'.<br>';
                        }
                    }
                }
            }
        }

        /** 
         * Método responsável por retornar o valor de um procediento, conforme tabela de preço
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @param String $cdnTabelaPreco - código da tabela de preço
         * @param Boolean $echo - dar echo no valor
         * @return Decimal - valor do procedimento.
         *
        **/
        public function procedimentoValor($cdnProcedimento = null, $cdnTabelaPreco = null, $echo = true){
            if(is_null($cdnProcedimento) and is_null($cdnTabelaPreco)){
                $cdnProcedimento = $_GET['cdnProcedimento'];
                $cdnTabelaPreco = $_GET['tabela'];
            }
            if(substr($cdnTabelaPreco, 0, 8) == 'parceria'){
                $cdnParceria = substr($cdnTabelaPreco, 8);
                if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                    $arrCond = array(
                        'cdnParceria' => $cdnParceria,
                        'conscond1' => 'AND',
                        'cdnProcedimento' => $cdnProcedimento
                    );
                    $valProcedimento = $this->modelo->consultar('parceria_preco', '*', $arrCond)[0]['valPreco'];
                    if($echo)
                        echo $valProcedimento;
                    return $valProcedimento;
                }
            }else{
                if($this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco)){
                    $arrCond = array(
                        'cdnTabelaPreco' => $cdnTabelaPreco,
                        'conscond1' => 'AND',
                        'cdnProcedimento' => $cdnProcedimento
                    );
                    $valProcedimento = $this->modelo->consultar('tabelapreco_procedimento', '*', $arrCond)[0]['valPreco'];
                    if($echo)
                        echo $valProcedimento;
                    return $valProcedimento;
                }

                
                if($echo)
                    echo 0;
                return 0;
            }
        }
    }
