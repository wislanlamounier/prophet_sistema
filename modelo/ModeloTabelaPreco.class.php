<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a parceria.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-26
     *
     **/
    class ModeloTabelaPreco extends Modelo {
        use Transformacao;
        use Validacao;

        /**
         * Método utilizado para retornar o objeto DTO
         * da tabela requisitada
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela
         * @return Object - objeto DTO da frase
         *
         **/
        public function getTabelaPreco($cdnTabelaPreco) {
            return $this->getRegistro('tabelapreco', 'cdnTabelaPreco', $cdnTabelaPreco);
        }

        /**
         * Método responsável por cadastrar a tabela de preço
         *
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function tabelaPrecoCadastrarFim() {
            $nomTabelaPreco = $_POST['nomTabelaPreco'];
            $dtoTabelaPreco = new DTOTabelapreco();
            if (!$dtoTabelaPreco->setNomTabelaPreco($nomTabelaPreco)) {
                return false;
            }

            $arrDados = $dtoTabelaPreco->getArrayBanco();
            if ($this->inserir('tabelapreco', $arrDados)) {
                $cdnTabelaPreco = $this->ultimoInserido('tabelapreco');
                if (!$this->tabelaPrecoCadastrarProcedimentos($cdnTabelaPreco)) {
                    $this->deletar('tabelapreco', array('cdnTabelaPreco' => $cdnTabelaPreco));

                    return false;
                }

                return true;
            } else {
                return false;
            }
        }

        /**
         * Método responsável por atualizar a tabela de preço
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela de preço
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function tabelaPrecoAtualizarFim($cdnTabelaPreco) {
            $nomTabelaPreco = $_POST['nomTabelaPreco'];
            $dtoTabelaPreco = $this->getTabelaPreco($cdnTabelaPreco);
            $oldTabelaPreco = $this->getTabelaPreco($cdnTabelaPreco);
            if (!$dtoTabelaPreco->setNomTabelaPreco($nomTabelaPreco)) {
                return false;
            }

            $arrDados = $dtoTabelaPreco->getArrayBanco();
            if ($this->atualizar('tabelapreco', $arrDados, array('cdnTabelaPreco' => $cdnTabelaPreco))) {
                if (!$this->tabelaPrecoCadastrarProcedimentos($cdnTabelaPreco)) {
                    $oldTabelaPreco = $oldTabelaPreco->getArrayBanco();
                    $this->atualizar('tabelapreco', $oldTabelaPreco, array('cdnTabelaPreco' => $cdnTabelaPreco));

                    return false;
                }

                return true;
            } else {
                return false;
            }
        }

        /**
         * Método responsável por cadastrar os procedimentos na tabela de preço.
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela de preço.
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function tabelaPrecoCadastrarProcedimentos($cdnTabelaPreco) {
            $novo = !$this->checaExiste('tabelapreco_procedimento', 'cdnTabelaPreco', $cdnTabelaPreco);
            if (!$novo)
                $arrPrecos = $this->consultar('tabelapreco_procedimento', '*', array('cdnTabelaPreco' => $cdnTabelaPreco));

            $finalizou = true;
            foreach ($_POST as $cdnProcedimento => $valPreco) {
                if ($cdnProcedimento == 'nomTabelaPreco')
                    continue;

                $valPreco = $this->transformacaoDecimal($valPreco);
                if ($this->validacaoDecimal($valPreco)) {
                    $arrDados = array('cdnTabelaPreco'  => $cdnTabelaPreco,
                                      'cdnProcedimento' => $cdnProcedimento,
                                      'valPreco'        => $valPreco);
                    $arrCond = array('cdnProcedimento' => $cdnProcedimento,
                                     'conscond1'       => 'AND',
                                     'cdnTabelaPreco'  => $cdnTabelaPreco);

                    $arrNewPrecos = $this->consultar('tabelapreco_procedimento', '*', $arrCond);
                    if (count($arrNewPrecos) > 0) {
                        $arrCond = array('cdnTabelaPreco'  => $cdnTabelaPreco,
                                         'conscond1'       => 'AND',
                                         'cdnProcedimento' => $cdnProcedimento);
                        if (!$this->atualizar('tabelapreco_procedimento', $arrDados, $arrCond))
                            $finalizou = false;
                    } else {
                        if (!$this->inserir('tabelapreco_procedimento', $arrDados))
                            $finalizou = false;
                    }
                } else {
                    $finalizou = false;
                }

            }
            if (!$finalizou) {
                $this->deletar('tabelapreco_procedimento', array('cdnTabelaPreco' => $cdnTabelaPreco));
                if (!$novo) {
                    foreach ($arrPrecos as $arrPreco) {
                        $this->inserir('tabelapreco_procedimento', $arrPreco);
                    }
                }

                return false;
            }

            return true;
        }

        public function tabelaPrecoImprimir($cdnTabelaPreco, $parceria = false) {

            if ($parceria) {
                $modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($cdnTabelaPreco);
                $nome = $dtoParceria->getNomParceria();
                $procedimentos = $this->consultar('parceria_preco', '*', array('cdnParceria' => $cdnTabelaPreco));

            } else {
                $dtoTabelaPreco = $this->getTabelaPreco($cdnTabelaPreco);
                $nome = $dtoTabelaPreco->getNomTabelaPreco();
                $procedimentos = $this->consultar('tabelapreco_procedimento', '*', array('cdnTabelaPreco' => $cdnTabelaPreco));
            }

            $modAreaAtuacao = new ModeloAreaAtuacao();
            $modProcedimento = new ModeloProcedimento();
            $fim = array();
            foreach($procedimentos as $procedimento){
                $dtoProcedimento = $modProcedimento->getProcedimento($procedimento['cdnProcedimento']);
                if(!isset($fim[$dtoProcedimento->getCdnAreaAtuacao()]))
                    $fim[$dtoProcedimento->getCdnAreaAtuacao()] = array();
                $fim[$dtoProcedimento->getCdnAreaAtuacao()][] = array($dtoProcedimento, $procedimento['valPreco']);
            }

            $pdfTabelaPreco = new PDFTabelaPreco('P', 'mm');

            $pdfTabelaPreco->setNomTabelaPreco($nome);

            $pdfTabelaPreco->AddPage();
            $pdfTabelaPreco->AliasNbPages();


            foreach($fim as $cdnAreaAtuacao => $procedimentos){
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
                $pdfTabelaPreco->SetFont('Arial', 'B', 11);
                $pdfTabelaPreco->SetWidths(0);
                $pdfTabelaPreco->SetBorders('');
                $pdfTabelaPreco->SetAligns('C');
                $pdfTabelaPreco->PutRow(array('Área de atuação: '.$dtoAreaAtuacao->getNomAreaAtuacao()), true);

                $pdfTabelaPreco->SetFont('Arial', 'B', 11);
                $pdfTabelaPreco->SetWidths(array(95, 95));
                $pdfTabelaPreco->SetBorders(array('B', 'B'));
                $pdfTabelaPreco->SetAligns(array('L', 'C'));
                
                $pdfTabelaPreco->PutRow(array('Procedimento', 'Valor'), true);

                $pdfTabelaPreco->SetFont('Arial', '', 10);
                $pdfTabelaPreco->SetBorders(array('', ''));
                foreach($procedimentos as $dtoProcedimento){
                    $valProcedimento = $dtoProcedimento[1];
                    $dtoProcedimento = $dtoProcedimento[0];
                    $valProcedimento = $dtoProcedimento->transformacaoMonetario($valProcedimento);

                    $yIni = $pdfTabelaPreco->GetY();
                    $pdfTabelaPreco->PutRow(array($dtoProcedimento->getNomProcedimento(), 'R$'.$valProcedimento), true);
                    $yFim = $pdfTabelaPreco->GetY();
                    $h = $yFim - $yIni;
                    $pdfTabelaPreco->Rect(10, $yIni, 95, $h);
                    $pdfTabelaPreco->Rect(105, $yIni, 95, $h);
                }

                $pdfTabelaPreco->Ln(10);
            }


            $pdfTabelaPreco->OutPut();

        }

    }