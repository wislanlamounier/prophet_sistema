<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * das tabelas de preco
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-12-21
     *
    **/
    class ControleTabelaPreco extends Controlador{

        use Transformacao;

        /**
         * Método responsável por mostrar a página de cadastro de tabela de preço
         *
         * @return Void.
         *
        **/
        public function tabelaPrecoCadastrar(){
            $arrConsulta = $this->modelo->consultar('areaatuacao', '*', array('indDesvinculada' => 0), 'cdnAreaAtuacao');
            $arrProcedimentosFim = array();
            foreach($arrConsulta as $arrAreaAtuacao){
                if(!isset($arrProcedimentosFim[$arrAreaAtuacao['nomAreaAtuacao']]))
                    $arrProcedimentosFim[$arrAreaAtuacao['nomAreaAtuacao']] = array();

                $arrCond = array('cdnAreaAtuacao' => $arrAreaAtuacao['cdnAreaAtuacao'],
                                 'conscond1' => 'AND',
                                 'indDesvinculado' => 0);

                $arrProcedimentos = $this->modelo->consultar('procedimento', '*', $arrCond);
                foreach($arrProcedimentos as $arrProcedimento){
                    $arrProcedimentosFim[$arrAreaAtuacao['nomAreaAtuacao']][] = $arrProcedimento;
                }
            }
            $this->visualizador->atribuirValor('arrProcedimentosFim', $arrProcedimentosFim);

            $this->visualizador->atribuirValor('modAreaAtuacao', new ModeloAreaAtuacao());
            $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());

            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar tabela de preço');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da tabela de preço
         *
         * @return Void.
         *
        **/
        public function tabelaPrecoCadastrarFim(){
            $modTabelaPreco = new ModeloTabelaPreco();
            if($modTabelaPreco->tabelaPrecoCadastrarFim()){
                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $cdnTabelaPreco = $this->modelo->ultimoInserido('tabelapreco');
                $this->log(array('sucesso', 'cadastro', 'tabelapreco', $cdnTabelaPreco));
                $this->tabelaPrecoConsultarFim($cdnTabelaPreco);
            }else{
                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->log(array('erro', 'cadastro', 'tabelapreco'));
                $this->tabelaPrecoCadastrar();
            }
            return;
        }

        /**
         * Método responsável por mostrar as tabelas de preço cadastradas
         *
         * @return Void.
         *
        **/
        public function tabelaPrecoConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            
            $arrTabelaPreco = $this->modelo->consultar('tabelapreco');
            $this->visualizador->atribuirValor('arrTabelaPreco', $arrTabelaPreco);

            $this->visualizador->addJs('js/tabelaPrecoConsultar.js');
            $this->visualizador->mostrarNaTela('consultar', 'Tabelas de preço');
            return;
        }

        /**
         * Método responsável por mostrar uma tabela de preco
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela de preço
         * @return Void.
         *
        **/
        public function tabelaPrecoConsultarFim($cdnTabelaPreco){
            if($this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco)){
                $arrProcedimentos = $this->modelo->consultar('procedimento', '*', array('indDesvinculado' => 0), 'cdnAreaAtuacao');
                $this->visualizador->atribuirValor('arrProcedimentos', $arrProcedimentos);

                $this->visualizador->atribuirValor('modAreaAtuacao', new ModeloAreaAtuacao());
                $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());

                $modTabelaPreco = new ModeloTabelaPreco();
                $dtoTabelaPreco = $modTabelaPreco->getTabelaPreco($cdnTabelaPreco);

                $this->visualizador->atribuirValor('dtoTabelaPreco', $dtoTabelaPreco);

                $this->visualizador->mostrarNaTela('consultarFim', 'Tabela de preço - '.$dtoTabelaPreco->getNomTabelaPreco());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de edição de tabela de preço
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela de preço
         * @return Void.
         *
        **/
        public function tabelaPrecoAtualizar($cdnTabelaPreco){
            if($this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco)){


                $arrConsulta = $this->modelo->consultar('areaatuacao', '*', array('indDesvinculada' => 0), 'cdnAreaAtuacao');
                $arrProcedimentosFim = array();
                foreach($arrConsulta as $arrAreaAtuacao){
                    if(!isset($arrProcedimentosFim[$arrAreaAtuacao['nomAreaAtuacao']]))
                        $arrProcedimentosFim[$arrAreaAtuacao['nomAreaAtuacao']] = array();

                    $arrCond = array('cdnAreaAtuacao' => $arrAreaAtuacao['cdnAreaAtuacao'],
                                     'conscond1' => 'AND',
                                     'indDesvinculado' => 0);

                    $arrProcedimentos = $this->modelo->consultar('procedimento', '*', $arrCond);
                    foreach($arrProcedimentos as $arrProcedimento){

                        $arrCond = array(
                            'cdnTabelaPreco' => $cdnTabelaPreco,
                            'conscond1' => 'AND',
                            'cdnProcedimento' => $arrProcedimento['cdnProcedimento']
                        );
                        $arrPreco = $this->modelo->consultar('tabelapreco_procedimento', '*', $arrCond)[0];
                        $arrProcedimento['valPreco'] = $this->transformacaoMonetario($arrPreco['valPreco']);
                        $arrProcedimentosFim[$arrAreaAtuacao['nomAreaAtuacao']][] = $arrProcedimento;
                    }
                }
                $this->visualizador->atribuirValor('arrProcedimentosFim', $arrProcedimentosFim);

                $modTabelaPreco = new ModeloTabelaPreco();
                $dtoTabelaPreco = $modTabelaPreco->getTabelaPreco($cdnTabelaPreco);

                $this->visualizador->atribuirValor('dtoTabelaPreco', $dtoTabelaPreco);

                $this->visualizador->mostrarNaTela('atualizar', 'Editar tabela de preço - '.$dtoTabelaPreco->getNomTabelaPreco());
                return;

            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por atualizar a tabela de preço
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela
         * @return Void.
         *
        **/
        public function tabelaPrecoAtualizarFim($cdnTabelaPreco){
            if($this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco)){
                $modTabelaPreco = new ModeloTabelaPreco();
                if($modTabelaPreco->tabelaPrecoAtualizarFim($cdnTabelaPreco)){
                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->log(array('sucesso', 'editar', 'tabelapreco', $cdnTabelaPreco));
                    $this->tabelaPrecoConsultarFim($cdnTabelaPreco);
                }else{
                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->log(array('erro', 'editar', 'tabelapreco'));
                    $this->tabelaAtualizar($cdnTabelaPreco);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        public function tabelaPrecoImprimir($cdnTabelaPreco, $parceria = 0){
            $modTabelaPreco = new ModeloTabelaPreco();
            if($parceria){
                if(!$this->modelo->checaExiste('parceria_preco', 'cdnParceria', $cdnTabelaPreco))
                    return $this->erroExistente();
            }else{
                if(!$this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco))
                    return $this->erroExistente();
            }
            return $modTabelaPreco->tabelaPrecoImprimir($cdnTabelaPreco, $parceria);
        }
    }