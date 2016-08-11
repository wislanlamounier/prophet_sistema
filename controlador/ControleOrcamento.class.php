<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * dos orçamentos
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-10-13
     *
    **/
    class ControleOrcamento extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de orçamento
         *
        **/
        public function orcamentoCadastrar(){
            $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
            $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');

            $this->visualizador->addCss('plugins/select2/dist/css/select2.css');
            $this->visualizador->addJs('plugins/select2/dist/js/select2.full.js');

            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');

            $this->visualizador->addJs('js/pacienteSelect.js');
            $this->visualizador->addJs('js/consultaCadastrar.js');
            $this->visualizador->addJs('js/orcamentoCadastrar.js');

            $arrPacientes = $this->modelo->consultar('paciente', '*', array('indDesvinculado' => 0), 'nomPaciente');
            $this->visualizador->atribuirValor('arrPacientes', $arrPacientes);

            $modMain = new ModeloMain(true);

            $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
            $arrUsuarios = array();
            foreach($arrDentistas as $arrDentista){
                $arrUsuarios[] = $modMain->getUsuario($arrDentista['cdnUsuario']);
            }

            $arrDentistas = $arrUsuarios;
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            $this->visualizador->atribuirValor('arrAreasAtuacao', $this->modelo->consultar('areaatuacao', '*', array('indDesvinculada' => 0)));
            $this->visualizador->atribuirValor('arrConsultorios', $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0)));

            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Orçamento');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do orçamento
         *
        **/
        public function orcamentoCadastrarFim(){
            $modOrcamento = new ModeloOrcamento();
            $arrValidacao = $modOrcamento->orcamentoPreparaDTO();
            $dtoOrcamento = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
                $this->visualizador->setFlash($mesErro, 'erro');
                $this->orcamentoCadastrar();
                return;
            }

            $retorno = $modOrcamento->orcamentoCadastrarFim($dtoOrcamento);

            if($retorno === true){

                $cdnOrcamento = $modOrcamento->ultimoInserido('orcamento');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'orcamento', $cdnOrcamento));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->orcamentoConsultarFim($cdnOrcamento);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'orcamento'));

                $this->visualizador->setFlash($retorno, 'erro');
                $this->orcamentoCadastrar();
                return;

            }
        }

        /**
         * Método responsável por mostrar a página de consulta de orçamentos
         *
         * @return Void.
         *
        **/
        public function orcamentoConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $modOrcamento = new ModeloOrcamento();
            $arrOrcamentos = $modOrcamento->consultar('orcamento', '*', false, 'indAprovado');
            $this->visualizador->atribuirValor('arrOrcamentos', $arrOrcamentos);
            $this->visualizador->atribuirValor('modOrcamento', $modOrcamento);

            $this->visualizador->atribuirValor('modPaciente', new ModeloPaciente());

            $this->visualizador->mostrarNaTela('consultar', 'Orçamentos');
            return;

        }

        /**
         * Método responsável por mostrar a página de um orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Void.
         *
        **/
        public function orcamentoConsultarFim($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
                $this->visualizador->addJs('js/orcamentoConsultarFim.js');
                $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');

                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                $this->visualizador->atribuirValor('dtoOrcamento', $dtoOrcamento);
                
                $arrDatOrcamento = explode("-", $dtoOrcamento->getDatOrcamento());
                $datOrcamentoBr = $arrDatOrcamento[2] . "/" . $arrDatOrcamento[1] . "/" . $arrDatOrcamento[0];
                $this->visualizador->atribuirValor('datOrcamentoBr', $datOrcamentoBr);
                
                $arrDatValidade = explode("-", $dtoOrcamento->getDatValidade());
                $datValidadeBr = $arrDatValidade[2] . "/" . $arrDatValidade[1] . "/" . $arrDatValidade[0];
                $this->visualizador->atribuirValor('datValidadeBr', $datValidadeBr);

                // Usuário que aprovou
                $modMain = new ModeloMain(true);
                if($dtoOrcamento->getIndAprovado()){
                    if(!is_null($dtoOrcamento->getCdnUsuarioAprovou())){
                        $arrUsuarioAprovou = $modMain->getUsuario($dtoOrcamento->getCdnUsuarioAprovou());
                    }else{
                        $arrUsuarioAprovou = array('nomUsuario' => '');
                    }
                    $this->visualizador->atribuirValor('arrUsuarioAprovou', $arrUsuarioAprovou);
                }


                // Paciente e titular
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoOrcamento->getCdnPaciente(), true);
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $nomTitulo = $arrPaciente['nomPaciente'];

                // Procedimentos
                $arrProcedimentos = $this->modelo->consultar('orcamento_procedimento', '*', array('cdnOrcamento' => $cdnOrcamento));
                $this->visualizador->atribuirValor('arrProcedimentos', $arrProcedimentos);
                $this->visualizador->atribuirValor('modMain', $modMain);
                $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());
                $this->visualizador->atribuirValor('modAreaAtuacao', new ModeloAreaAtuacao());

                // Parcelas
                if($this->modelo->checaExiste('orcamento_parcela', 'cdnOrcamento', $cdnOrcamento)){
                    $arrParcelas = $modOrcamento->getOrcamentoParcela($cdnOrcamento);
                    $this->visualizador->atribuirValor('arrParcelas', $arrParcelas);
                }

                // Forma de pagamento
                if($this->modelo->checaExiste('orcamento_formapagamento', 'cdnOrcamento', $cdnOrcamento)){
                    $dtoOrcamentoFormaPagamento = $modOrcamento->getOrcamentoFormaPagamento($cdnOrcamento);
                    $this->visualizador->atribuirValor('dtoOrcamentoFormaPagamento', $dtoOrcamentoFormaPagamento);
                }

                // Tabela de preço
                $cdnTabelaPreco = $dtoOrcamento->getCdnTabelaPreco();
                if(substr($cdnTabelaPreco, 0, 8) == 'parceria'){
                    $cdnParceria = substr($cdnTabelaPreco, 8);
                    if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                        $modParceria = new ModeloParceria();
                        $dtoParceria = $modParceria->getParceria($cdnParceria);
                        $this->visualizador->atribuirValor('nomTabelaPreco', $dtoParceria->getNomParceria());
                    }
                }else{
                    if($this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco)){
                        $modTabelaPreco = new ModeloTabelaPreco();
                        $dtoTabelaPreco = $modTabelaPreco->getTabelaPreco($cdnTabelaPreco);
                        $this->visualizador->atribuirValor('nomTabelaPreco', $dtoTabelaPreco->getNomTabelaPreco());
                    }
                }

                // Tabela de formas de pagamento
                if(!isset($arrParcelas)){
                    $arrParcelas = array();
                    $numVezes = 6;
                    $aVista = array(
                        'numVezes' => 'A VISTA',
                        'valores' => '1x de R$'.$dtoOrcamento->getValOrcamento(true),
                        'valOrcamento' => $dtoOrcamento->getValOrcamento(true),
                        'valTaxas' => '0,00'
                    );
                    $arrParcelas[] = $aVista;
                    if($numVezes > 1){

                        if($dtoOrcamento->getIndCobrarJuros()) {
                            $dtoConfiguracoes = $modMain->getConfiguracoes();
                            $taxa = $dtoConfiguracoes->getValJurosOrcamento();
                        }else{
                            $taxa = 0;
                        }

                        for($i = 2; $i <= $numVezes; $i++){
                            $valor = $dtoOrcamento->getValOrcamento();
                            $valor = floatval($valor) *  pow((1 +  floatval($taxa)/100), intval($i));
                            $valor = round($valor, 2);

                            $parcelas = array(
                                'unica' => 0,
                                'geral' => 0,
                                'vezes' => 0,
                            );

                            $soma = 0;
                            for($j = 1; $j < $i; $j++){
                                $valorMes = $valor/$i;
                                $valorMes = round($valorMes, 2);
                                $parcelas['geral'] = $valorMes;
                                $soma = $soma + $valorMes;
                            }
                            $valorMes = $valor - $soma;
                            $valorMes = round($valorMes, 2);
                            $parcelas['unica'] = $valorMes;
                            if($parcelas['unica'] != $parcelas['geral']){
                                $parcelas['vezes'] = $i - 1;
                                $texto = $parcelas['vezes'].'x de R$'.number_format($parcelas['geral'], 2, ',', '.').' + 1x de R$'.number_format($parcelas['unica'], 2, ',', '.');
                            }else{
                                $parcelas['vezes'] = $i;
                                $texto = $parcelas['vezes'].'x de R$'.number_format($parcelas['geral'], 2, ',', '.');
                            }


                            $arrParcelas[] = array(
                                'numVezes' => $i,
                                'valores' => $texto,
                                'valOrcamento' => number_format($valor, 2, ',', '.'),
                                'valTaxas' => number_format($valor - $dtoOrcamento->getValOrcamento(), 2, ',', '.')
                            );
                        }
                    }
                    $this->visualizador->atribuirValor('arrParcelas', $arrParcelas);
                }


                $this->visualizador->atribuirValor('tipoVisualizacao', 'consultarFim');

                $this->visualizador->atribuirValor('cdnOrcamento', $cdnOrcamento);

                $this->visualizador->mostrarNaTela('consultarFim', 'ORÇAMENTO NÚMERO '.$cdnOrcamento.' - '.$nomTitulo);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de aprovação de orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Void.
         *
        **/
        public function orcamentoAprovar($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                if($dtoOrcamento->getIndAprovado() === 0){
                    $this->visualizador->setFlash('Orçamento já foi reprovado.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }
                $dtoOrcamentoFormaPagamento = $modOrcamento->getOrcamentoFormaPagamento($cdnOrcamento);
                if(is_null($dtoOrcamentoFormaPagamento->getNumVezesEscolhido())){
                    $this->visualizador->setFlash('Forma de pagamento ainda não foi escolhida para este orçamento.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }
                if(!$dtoOrcamento->getIndAprovado()){
                    if(strtotime($dtoOrcamento->getDatValidade()) >= strtotime(date('Y-m-d'))){
                        $this->visualizador->atribuirValor('dtoOrcamento', $dtoOrcamento);

                        $modPaciente = new ModeloPaciente();
                        $arrPaciente = $modPaciente->getPaciente($dtoOrcamento->getCdnPaciente(), true);
                        $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);


                        // Procedimentos que serão realizados
                        $arrProcedimentos = $this->modelo->consultar('orcamento_procedimento', '*', array('cdnOrcamento' => $cdnOrcamento));
                        $this->visualizador->atribuirValor('arrProcedimentos', $arrProcedimentos);
                        $this->visualizador->atribuirValor('modMain', new ModeloMain(true));
                        $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());
                        $this->visualizador->atribuirValor('modAreaAtuacao', new ModeloAreaAtuacao());

                        $this->visualizador->atribuirValor('dtoOrcamentoFormaPagamento', $dtoOrcamentoFormaPagamento);
                        $this->visualizador->mostrarNaTela('aprovar', 'Aprovar orçamento - '.$arrPaciente['nomPaciente']);
                        return;
                    }
                    $this->visualizador->setFlash('Este orçamento já ultrapassou a sua validade.', 'erro');
                    return $this->orcamentOConsultarFim($cdnOrcamento);
                }
                $this->visualizador->setFlash('Este orçamento já foi aprovado.', 'erro');
                return $this->orcamentoConsultarFim($cdnOrcamento);
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por realizar a aprovação de um orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Void.
         *
        **/
        public function orcamentoAprovarFim($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                if($dtoOrcamento->getIndAprovado() === 0){
                    $this->visualizador->setFlash('Orçamento já foi reprovado.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }
                $ret = $modOrcamento->orcamentoCalcularValorFinal($dtoOrcamento);
                if($ret[0]){
                    $dtoOrcamento = $ret[1];
                    if($modOrcamento->orcamentoCadastrarFormaPagamento($dtoOrcamento)){
                        if($_POST['numVezes'] > 1) {
                            if (!$modOrcamento->orcamentoPreparaParcelas($dtoOrcamento)) {
                                $this->modelo->deletar('orcamento_formapagamento', array('cdnOrcamento' => $cdnOrcamento));
                                $this->log(array('erro', 'aprovacao', 'orcamento', $cdnOrcamento));
                                $this->visualizador->setFlash('Ocorreu um erro ao aprovar o orçamento.', 'erro');
                                $this->orcamentoConsultarFim($cdnOrcamento);

                                return;
                            }
                        }
                        if(!$modOrcamento->orcamentoAprovarFim($dtoOrcamento)){
                            $this->modelo->deletar('orcamento_parcela', array('cdnOrcamento' => $cdnOrcamento));
                            $this->modelo->deletar('orcamento_formapagamento', array('cdnOrcamento' => $cdnOrcamento));
                            $this->log(array('erro', 'aprovacao', 'orcamento', $cdnOrcamento));
                            $this->visualizador->setFlash('Ocorreu um erro ao aprovar o orçamento.', 'erro');
                            $this->orcamentoConsultarFim($cdnOrcamento);
                            return;
                        }
                        $this->log(array('sucesso', 'aprovacao', 'orcamento', $cdnOrcamento));
                        $this->visualizador->setFlash('Orçamento aprovado com sucesso.', 'sucesso');
                        $this->orcamentoConsultarFim($cdnOrcamento);
                        return;
                    }else{
                        $this->log(array('erro', 'aprovacao', 'orcamento', $cdnOrcamento));
                        $this->visualizador->setFlash('Ocorreu um erro ao aprovar o orçamento.', 'erro');
                        $this->orcamentoConsultarFim($cdnOrcamento);
                        return;
                    }
                }else{
                    $this->log(array('erro', 'aprovacao', 'orcamento', $cdnOrcamento));
                    $this->visualizador->setFlash('Valor inválido.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }

            }
            $this->erroExistente();
            return;
        }

        public function orcamentoReprovar($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                $this->visualizador->atribuirValor('dtoOrcamento', $dtoOrcamento);

                $arrProcedimentos = $this->modelo->consultar('orcamento_procedimento', '*', array('cdnOrcamento' => $cdnOrcamento));
                $this->visualizador->atribuirValor('arrProcedimentos', $arrProcedimentos);

                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoOrcamento->getCdnPaciente(), true);
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);

                $this->visualizador->atribuirValor('modMain', new ModeloMain(true));
                $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());
                $this->visualizador->atribuirValor('modAreaAtuacao', new ModeloAreaAtuacao());


                return $this->visualizador->mostrarNaTela('reprovar', 'Reprovar orçamento');
            }
            $this->erroExistente();
            return;
        }

        public function orcamentoReprovarFim($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                $dtoOrcamento->setIndAprovado(0);
                $this->modelo->atualizar('orcamento', $dtoOrcamento->getArrayBanco(), array('cdnOrcamento' => $cdnOrcamento));
                $this->visualizador->setFlash('Orçamento reprovado com sucesso.', 'sucesso');
                $this->orcamentoConsultarFim($cdnOrcamento);
                return;
            }
            $this->erroExistente();
            return;
        }

        public function orcamentoDesativar($params){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $params["cdnOrcamento"])){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($params["cdnOrcamento"]);
                $dtoOrcamento->setIndDesativado(1);
                $dtoOrcamento->setDatDesativado(date("Y-m-d"));
                $dtoOrcamento->setStrJustificativa($params["strJustificativa"]);
                $this->modelo->atualizar('orcamento', $dtoOrcamento->getArrayBanco(), array('cdnOrcamento' => $params["cdnOrcamento"]));
                $this->visualizador->setFlash('Orçamento desativado com sucesso.', 'sucesso');
                $this->orcamentoConsultarFim($params["cdnOrcamento"]);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por gerar a nota promissória
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @param Integer $numParcela - número da parcela (opcional)
         * @return Void.
         *
        **/
        public function orcamentoNotaPromissoria($cdnOrcamento, $numParcela = 0){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                if($this->modelo->checaExiste('orcamento_parcela', 'cdnOrcamento', $cdnOrcamento)){
                    if($numParcela != 0){
                        $modOrcamento = new ModeloOrcamento();
                        if(!$modOrcamento->orcamentoNotaPromissoria($cdnOrcamento, $numParcela)){
                            $this->visualizador->setFlash('Informe um número de parcela válido.', 'erro');
                            $this->orcamentoConsultarFim($cdnOrcamento);
                            return;
                        }
                    }else{
                        $this->visualizador->setFlash('Informe o número da parcela.', 'erro');
                        $this->orcamentoConsultarFim($cdnOrcamento);
                        return;
                    }
                }else{
                    $modOrcamento = new ModeloOrcamento();
                    $modOrcamento->orcamentoNotaPromissoria($cdnOrcamento);
                    return;
                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por gerar o carnê do orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Void.
         *
        **/
        public function orcamentoCarne($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                if(!$modOrcamento->orcamentoCarne($cdnOrcamento)){
                    $this->visualizador->setFlash('Um problema ocorreu. Por favor, tente novamente.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por adicionar um procedimento na div de vínculo
         *
         * @param Integer $qtdProcedimentos - quantidade de procedimentos que estão na div + 1
         *
        **/
        public function orcamentoAdicionarProcedimento($qtdProcedimentos){
            $modDentista = new ModeloDentista();
            $arrDentistas = $modDentista->consultar('dentista', '*', array('indDesativado' => 0));
            $modMain = new ModeloMain(true);

            $div = '<div class="procedimento row" id="procedimento'.$qtdProcedimentos.'">';

            $div .= '<div class="col-md-6 form-group">';
            $div .= '<label id="lblCdnDentista'.$qtdProcedimentos.'" for="cdnDentista'.$qtdProcedimentos.'" class="control-label">Dentista '.$qtdProcedimentos.'</label>';
            $div .= '<select id="iptCdnDentista'.$qtdProcedimentos.'" name="cdnDentista'.$qtdProcedimentos.'" class="form-control selectDentista">';
            $div .= '<option></option>';
            foreach($arrDentistas as $arrDentista){
                $arrUsuario = $modMain->getUsuario($arrDentista['cdnUsuario']);
                $div .= '<option value="'.$arrUsuario['cdnUsuario'].'">'.$arrUsuario['nomUsuario'].'</option>';
            }
            $div .= '</select>';
            $div .= '</div>';


            $div .= '<div class="col-md-6 form-group">';
            $div .= '<label id="lblCdnAreaAtuacao'.$qtdProcedimentos.'" for="cdnAreaAtuacao'.$qtdProcedimentos.'" class="control-label">Área de atuação '.$qtdProcedimentos.'</label>';
            $div .= '<select id="iptCdnAreaAtuacao'.$qtdProcedimentos.'" name="cdnAreaAtuacao'.$qtdProcedimentos.'" class="form-control selectArea">';
            $div .= '</select>';
            $div .= '</div>';

            $div .= '<div class="col-md-3 form-group">';
            $div .= '<label id="lblCdnProcedimento'.$qtdProcedimentos.'" for="cdnProcedimento'.$qtdProcedimentos.'" class="control-label">Procedimento '.$qtdProcedimentos.'</label>';
            $div .= '<select id="iptCdnProcedimento'.$qtdProcedimentos.'" name="cdnProcedimento'.$qtdProcedimentos.'" class="form-control selectProcedimento">';
            $div .= '</select>';
            $div .= '</div>';

            $div .= '<div class="col-md-2 form-group">';
            $div .= '<label id="lblNumQuantidade'.$qtdProcedimentos.'" for="numQuantidade'.$qtdProcedimentos.'" class="control-label">Quantidade '.$qtdProcedimentos.'</label>';
            $div .= '<input type="number" value="1" id="iptNumQuantidade'.$qtdProcedimentos.'" name="numQuantidade'.$qtdProcedimentos.'" class="form-control inputQuantidade">';
            $div .= '</div>';

            $div .= '<div class="col-md-4 form-group">';
            $div .= '<label id="lblNumQDente'.$qtdProcedimentos.'" for="numDente'.$qtdProcedimentos.'" class="control-label">Dente '.$qtdProcedimentos.'</label>';
            $div .= '<input type="text" id="iptNumDente'.$qtdProcedimentos.'" name="numDente'.$qtdProcedimentos.'" class="form-control inputDente">';
            $div .= '</div>';

            $div .= '<div class="col-md-2 form-group">';
            $div .= '<label id="lblValProcedimento'.$qtdProcedimentos.'" for="valProcedimento'.$qtdProcedimentos.'" class="control-label">Valor un. '.$qtdProcedimentos.'</label>';
            $div .= '<input type="text" id="iptValProcedimento'.$qtdProcedimentos.'" name="valProcedimento'.$qtdProcedimentos.'" class="form-control inputValor mask-money">';
            $div .= '</div>';

            $div .= '<div class="col-xs-1 col-md-1 form-group"><br>';
            $div .= '<button type="button" class="btn btn-default btn-lg btnRemover" id="'.$qtdProcedimentos.'">';
            $div .= '<span class="fa fa-remove"></span>';
            $div .= '</button>';
            $div .= '</div>';


            $div .= '</div>';
            echo $div;
        }


        /**
         * Método responsável por imprimir um orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Void.
         *
        **/
        public function orcamentoImprimir($cdnOrcamento){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $modOrcamento->orcamentoImprimir($cdnOrcamento);
                return;
            }
            $this->erroExistente();
            return;
        }

        public function orcamentoParcelaAtualizar($cdnOrcamento, $numParcela){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoParcela = $modOrcamento->getOrcamentoParcela($cdnOrcamento, $numParcela);
                $this->visualizador->atribuirValor('dtoParcela', $dtoParcela);
                $this->visualizador->mostrarNaTela('parcelaAtualizar', 'Atualizar parcela');
                return;
            }
            $this->erroExistente();
            return;
        }

        public function orcamentoParcelaAtualizarFim($cdnOrcamento, $numParcela){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoParcela = $modOrcamento->getOrcamentoParcela($cdnOrcamento, $numParcela);
                if($modOrcamento->orcamentoParcelaAtualizarFim($dtoParcela, false)){
                    $this->log(array('sucesso', 'atualizar', 'parcela', $cdnOrcamento.'-'.$numParcela));
                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                }else{
                    $this->log(array('erro', 'atualizar', 'parcela', $cdnOrcamento.'-'.$numParcela));
                    $this->visualizador->setFlash(ERRO_CADASTRO, 'error');
                    $this->orcamentoParcelaAtualizar($cdnOrcamento, $numParcela);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        public function orcamentoEscolherForma($cdnOrcamento, $numVezes){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();


                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                if(!$dtoOrcamento->getIndAprovado() and !is_null($dtoOrcamento->getIndAprovado())){
                    $this->visualizador->setFlash('Orçamento já foi reprovado.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }
                if($dtoOrcamento->getIndAprovado()){
                    $this->visualizador->setFlash('Este orçamento já foi aprovado.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }

                if($numVezes < 1){
                    $this->visualizador->setFlash('Número de parcelas inválido', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }
                if($numVezes == 1){
                    $numVezes = 'A VISTA';
                    $valor = $dtoOrcamento->getValOrcamento();
                }else{
                    $valor = $dtoOrcamento->getValOrcamento();
                    $modMain = new ModeloMain(true);
                    $dtoConfiguracoes = $modMain->getConfiguracoes();
                    if($dtoOrcamento->getIndCobrarJuros())
                        $taxa = $dtoConfiguracoes->getValJurosOrcamento();
                    else
                        $taxa = 0;

                    $i = $numVezes;
                    $valor = floatval($valor) *  pow((1 +  floatval($taxa)/100), intval($i));
                    $valor = round($valor, 2);
                }
                $valor = $dtoOrcamento->transformacaoMonetario($valor);
                $this->visualizador->atribuirValor('valFinal', $valor);

                $this->visualizador->atribuirValor('numVezes', $numVezes);
                $this->visualizador->atribuirValor('dtoOrcamento', $dtoOrcamento);
                $this->visualizador->atribuirValor('cdnOrcamento', $cdnOrcamento);
                $this->visualizador->addJs('js/orcamentoDesconto.js');
                $this->visualizador->mostrarNaTela('escolherForma', 'Escolher forma de pagamento');
                return;
            }
            return $this->erroExistente;
        }

        public function orcamentoEscolherFormaFim($cdnOrcamento, $numVezes){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamentoFormaPagamento = $modOrcamento->getOrcamentoFormaPagamento($cdnOrcamento);
                if($dtoOrcamentoFormaPagamento->getNumVezes() < $numVezes){
                    $this->visualizador->setFlash('Número de parcelas inválido.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }

                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                if($dtoOrcamento->getIndAprovado() === 0){
                    $this->visualizador->setFlash('Orçamento já foi reprovado.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }

                if($dtoOrcamento->getIndAprovado()){
                    $this->visualizador->setFlash('Este orçamento já foi aprovado.', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }

                if($numVezes < 1){
                    $this->visualizador->setFlash('Número de parcelas inválido', 'erro');
                    $this->orcamentoConsultarFim($cdnOrcamento);
                    return;
                }

                $dtoOrcamentoFormaPagamento->setNumVezesEscolhido($numVezes);

                if($numVezes == 1){
                    $dtoOrcamentoFormaPagamento->setIndForma('aVista');
                    $dtoOrcamentoFormaPagamento->setDatVencimento($dtoOrcamentoFormaPagamento->getDatInicioPagamento());
                    $dtoOrcamentoFormaPagamento->setValFinalTaxas($dtoOrcamento->getValFinal());
                }else{
                    $dtoOrcamentoFormaPagamento->setIndForma('parcelado');
                    $taxa = $dtoOrcamentoFormaPagamento->getNumPorcentagem();
                    $valor = floatval($dtoOrcamento->getValFinal()) *  pow((1 +  floatval($taxa)/100), intval($numVezes));
                    $valor = round($valor, 2);
                    $dtoOrcamentoFormaPagamento->setValFinalTaxas($valor);
                }

                if($modOrcamento->orcamentoFormaPagamentoAtualizarFim($dtoOrcamentoFormaPagamento)){
                    if($numVezes > 1){
                        if(!$modOrcamento->orcamentoPreparaParcelas($cdnOrcamento, $numVezes, $dtoOrcamentoFormaPagamento->getNumPorcentagem())){
                            $dtoOrcamentoFormaPagamento->setNumVezes(null);
                            $modOrcamento->orcamentoFormaPagamentoAtualizarFim($dtoOrcamentoFormaPagamento);
                            $this->log(array('erro', 'escolher', 'formapagamento', $cdnOrcamento.' - '.$numVezes));
                            $this->visualizador->setFlash('Ocorreu algum problema na escolha de forma de pagamento.', 'erro');
                            $this->orcamentoConsultarFim($cdnOrcamento);
                            return;
                        }
                    }
                    $this->log(array('sucesso', 'escolher', 'formapagamento', $cdnOrcamento.' - '.$numVezes));
                    $this->visualizador->setFlash('Forma de pagamento escolhida com sucesso.', 'sucesso');
                }else{
                    $this->log(array('erro', 'escolher', 'formapagamento', $cdnOrcamento.' - '.$numVezes));
                    $this->visualizador->setFlash('Ocorreu algum problema na escolha de forma de pagamento.', 'erro');
                }
                $this->orcamentoConsultarFim($cdnOrcamento);
                return;
            }
            return $this->erroExistente();
        }

        public function orcamentoRegistrarPagamento($cdnOrcamento, $numParcela = 0){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){

                if($numParcela == '')
                    $numParcela = 0;

                $modOrcamento = new ModeloOrcamento();
                $arrRetorno = $modOrcamento->orcamentoValidaPagamento($cdnOrcamento, $numParcela);
                if(!$arrRetorno[0]){
                    $this->visualizador->setFlash('O pagamento não pôde ser registrado.', 'erro');
                    return $this->orcamentoConsultarFim($cdnOrcamento);
                }
                $dtoOrcamento = $arrRetorno[1];
                $this->visualizador->atribuirValor('dtoOrcamento', $dtoOrcamento);

                if($numParcela == 0){
                    $this->visualizador->atribuirValor('dtoFormaPagamento', $arrRetorno[2]);
                }else{
                    $this->visualizador->atribuirValor('dtoParcela', $arrRetorno[3]);
                }

                $this->visualizador->mostrarNaTela('registrarPagamento', 'Registrar pagamento');
                return;
            }
            return $this->erroExistente();
        }

        public function orcamentoRegistrarPagamentoFim($cdnOrcamento, $numParcela = 0){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){

                if($numParcela == '')
                    $numParcela = 0;

                $modOrcamento = new ModeloOrcamento();

                if($modOrcamento->orcamentoRegistrarPagamentoFim($cdnOrcamento, $numParcela)){

                    // fazer ligação com o módulo de fluxo financeiro
                    $pago = true; // retornar nessa variável se foi possível registrar a entrada de caixa
                    if($pago){
                        $dtoPagamento = new DTOPagamento();
                        $dtoPagamento->setCdnOrcamento($cdnOrcamento);
                        $dtoPagamento->setNumParcela(0);
                        $dtoPagamento->setNumNotaFiscal(isset($_POST['numNotaFiscal']) ? $_POST['numNotaFiscal'] : null);
                        $dtoPagamento->setValPagamento($_POST['valPagamento']);
                        $this->modelo->inserir('pagamento', $dtoPagamento->getArrayBanco());

                        $this->log(array('sucesso', 'registrar', 'orcamento_pagamento', $cdnOrcamento.' - '.$numParcela));
                        $this->visualizador->setFlash('Pagamento registrado com sucesso.', 'sucesso');
                    }else{
                        $modOrcamento->orcamentoDesfazerPagamento($cdnOrcamento, $numParcela);
                        $this->log(array('erro', 'registrar', 'orcamento_pagamento', $cdnOrcamento.' - '.$numParcela));
                        $this->visualizador->setFlash('Ocorreu algum problema no registro de pagamento.', 'erro');
                    }
                }else{
                    $this->log(array('erro', 'registrar', 'orcamento_pagamento', $cdnOrcamento.' - '.$numParcela));
                    $this->visualizador->setFlash('Ocorreu algum problema no registro de pagamento.', 'erro');
                }

                return $this->orcamentoConsultarFim($cdnOrcamento);


            }
            return $this->erroExistente();
        }

        public function orcamentoTaxa(){
            $modMain = new ModeloMain(true);
            $dtoConfiguracoes = $modMain->getConfiguracoes();
            echo $dtoConfiguracoes->getValJurosOrcamento();
        }

        public function orcamentoRelatorio($tipo = ''){
            $modOrcamento = new ModeloOrcamento();
            switch($tipo){
                case 'aprovados':
                    $modOrcamento->orcamentoRelatorioAprovados();
                    break;
                case 'reprovados':
                    $modOrcamento->orcamentoRelatorioReprovados();
                    break;
                default:
                    $this->visualizador->mostrarNaTela('relatorio', 'Relatórios de orçamentos');
                    break;
            }
            return;
        }

        public function orcamentoSalvarEdicao($params){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $params["cdnOrcamento"])){
                $modOrcamento = new ModeloOrcamento();
                $dtoOrcamento = $modOrcamento->getOrcamento($params["cdnOrcamento"]);
                $dtoOrcamento->setDatOrcamento($params["datOrcamento"]);
                $dtoOrcamento->setDatValidade($params["datValidade"]);
                $dtoOrcamento->setDesOrcamento($params["desOrcamento"]);
                $dtoOrcamento->setValOrcamento($params["valOrcamento"]);
                $this->modelo->atualizar('orcamento', $dtoOrcamento->getArrayBanco(), array('cdnOrcamento' => $params["cdnOrcamento"]));
                $this->visualizador->setFlash('Orçamento salvo com sucesso.', 'sucesso');
                $this->orcamentoConsultarFim($params["cdnOrcamento"]);
                return;
            }
            $this->erroExistente();
            return;
        }

    }
