<?php

    /**
     * Classe responsável pela impressão da nota promissória
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-21
     *
     **/
    class PDFOrcamento extends FPDF {
        use PDF_trait;
        use Transformacao;
        private $indParcela;
        private $dtoOrcamento;
        private $dtoParcela;
        private $dtoFormaPagamento;
        private $arrParcelas;
        private $cabecalho = null;
        public $tipo;

        /**
         * Método responsável pela definição do cabecalho da página
         *
         *
         **/
        public function Header() {
            $aligns = $this->GetAligns();
            $widths = $this->GetWidths();
            $borders = $this->GetBorders();


            if(!is_null($this->cabecalho)){
                if($this->cabecalho == 'aprovados')
                    $this->CabecalhoAprovados();
                if($this->cabecalho == 'reprovados')
                    $this->CabecalhoReprovados();
            }

            $this->SetWidths($widths);
            $this->SetAligns($aligns);
            $this->SetBorders($borders);
        }

        public function CabecalhoAprovados(){
            // Título
            $this->SetFont('Arial', 'B', '14');
            $this->SetAligns(array('C'));
            $this->SetWidths(array(0));
            // $this->SetBorders(array('B'));
            $this->PutRow(array('ORÇAMENTOS APROVADOS - ' . $_SESSION['nomClinica']), true);
            $this->SetFont('Arial', '', '11');
            $this->PutRow(array('PERÍODO: '.$this->periodo), true);
            // $this->Ln(10);


            // Cabeçalho
            $this->Ln(5);
            $this->SetWidths(array(15, 60, 50, 40, 25));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));
            $this->SetBorders(array('LTRB', 'LTRB', 'LTRB', 'LTRB', 'LTRB'));
            $this->SetFont('Arial', 'B', '10');
            $this->PutRow(array('Nro', 'Paciente', 'Valor - Forma', 'Por', 'Data'), true);
        }

        public function CabecalhoReprovados(){
            // Título
            $this->SetFont('Arial', 'B', '14');
            $this->SetAligns(array('C'));
            $this->SetWidths(array(0));
            // $this->SetBorders(array('B'));
            $this->PutRow(array('ORÇAMENTOS NÃO APROVADOS - ' . $_SESSION['nomClinica']), true);
            $this->SetFont('Arial', '', '11');
            $this->PutRow(array('PERÍODO: '.$this->periodo), true);
            // $this->Ln(10);


            // Cabeçalho
            $this->Ln(5);
            $this->SetWidths(array(15, 60, 40, 50, 25));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));
            $this->SetBorders(array('LTRB', 'LTRB', 'LTRB', 'LTRB', 'LTRB'));
            $this->SetBorders(array('LTRB', 'LTRB', 'LTRB', 'LTRB', 'LTRB'));
            $this->SetFont('Arial', 'B', '10');
            $this->PutRow(array('Nro', 'Paciente', 'Valor', 'Forma', 'Data'), true);
        }

        /**
         * Método responsável pela definição do rodapé da página
         *
         **/
        public function Footer() {
            if ($this->tipo == 'orcamento') {
                $this->SetY(-20);
                $this->Cell(0, 10, 'Assinatura do titular', 'T', 0, 'C');
            }
            if($this->tipo == 'aprovados'){
                $this->SetFont('Arial', '', 8);
                $this->SetY(-30);
                $this->Cell(0,30,'Página '.$this->PageNo().' de {nb}','',0,'R');
            }
        }

        public function SetCabecalho($cabecalho){
            $this->cabecalho = $cabecalho;
        }

        /**
         * Método responsável por setar se usa parcela
         *
         * @param Boolean $indParcela - usa parcela
         *
         **/
        public function SetIndParcela($indParcela) {
            $this->indParcela = $indParcela;
        }

        /**
         * Método responsável por retornar se usa parcela
         *
         * @return Boolean - usa parcela
         *
         **/
        public function GetIndParcela() {
            return $this->indParcela;
        }

        /**
         * Método responsável por setar o array de parcelas
         *
         * @param Array $arrParcelas - array de parcelas
         *
         **/
        public function SetArrParcelas($arrParcelas) {
            $this->arrParcelas = $arrParcelas;
        }

        /**
         * Método responsável por setar o DTO da parcela
         *
         * @param Object $dtoParcela - DTO da parcela
         *
         **/
        public function SetDtoParcela($dtoParcela) {
            $this->dtoParcela = $dtoParcela;
        }

        /**
         * Método responsável por setar o DTO do orçamento
         *
         * @param Object $dtoOrcamento - DTO do orçamento
         *
         **/
        public function SetDtoOrcamento($dtoOrcamento) {
            $this->dtoOrcamento = $dtoOrcamento;
        }

        public function SetDtoFormaPagamento($dtoFormaPagamento) {
            $this->dtoFormaPagamento = $dtoFormaPagamento;
        }

        /**
         * Método responsável por gerar a nota promissória
         *
         **/
        public function GerarNotaPromissoria() {

            if ($this->indParcela) {
                $datVencimento = $this->dtoParcela->getDatVencimento();
                $datVencimento = explode('-', $datVencimento);

                $valNota = $this->dtoParcela->getValParcela(true);

                $numParcela = new Modelo();
                $numParcela = $numParcela->query('SELECT COUNT(cdnOrcamento) as qtd FROM orcamento_parcela WHERE
                                          cdnOrcamento = ' . $this->dtoOrcamento->getCdnOrcamento())[0]['qtd'];
                $numParcela = $this->dtoParcela->getNumParcela() . ' de ' . $numParcela;

            } else {
                $dtoFormaPagamento = new ModeloOrcamento();
                $dtoFormaPagamento = $dtoFormaPagamento->getOrcamentoFormaPagamento($this->dtoOrcamento->getCdnOrcamento());

                $datVencimento = $dtoFormaPagamento->getDatVencimento();
                $datVencimento = explode('-', $datVencimento);
                $numParcela = '1 de 1';

                $valNota = $this->dtoOrcamento->getValFinal(true);
            }

            $diaVencimento = $datVencimento[2];
            $mesVencimento = $this->transformacaoNomeMes($datVencimento[1]);
            $anoVencimento = $datVencimento[0];


            $this->Image('arquivos_impressao/notaPromissoria.jpg', 3.5, 3.5, 200, 82.8);

            $nomClinica = $_SESSION['nomClinica'];
            $dtoClinica = new ModeloClinica(true);
            $dtoClinica = $dtoClinica->getClinica($_SESSION['cdnClinica']);

            $arrPaciente = new ModeloPaciente();
            $arrPaciente = $arrPaciente->getPaciente($this->dtoOrcamento->getCdnPaciente(), true);


            // Informações esquerda
            $this->SetFont('Arial', '', 8);
            $this->RotatedText(12, 69, $this->transformacaoTiraAcento($nomClinica), 90);
            $this->RotatedText(19.5, 65, $dtoClinica->getCodCpfCnpj(), 90);
            $this->RotatedText(27, 67, $arrPaciente['nomPaciente'], 90);

            // Informações cima
            $this->SetFont('Arial', '', 9);
            $this->SetXY(135, 10);
            $this->Cell(0, 0, 'Vencimento: ' . $diaVencimento . ' de ' . $mesVencimento . ' de ' . $anoVencimento);

            $this->SetFont('Arial', '', 11);
            $this->SetXY(53.2, 20);
            $this->Cell(0, 0, $numParcela);

            $this->SetXY(152, 20);
            $this->Cell(0, 0, $valNota);


            // Informações centro
            $texto = 'Aos ' . $diaVencimento . ' de ' . $mesVencimento . ' de ' . $anoVencimento . ' pagarei por esta única via ';
            $texto .= 'de NOTA PROMISSÓRIA à ' . $_SESSION['nomClinica'] . ' - ' . $dtoClinica->getCodCpfCnpj() . ' ou à ';
            $texto .= 'sua ordem a quantia de:';
            $this->SetFont('Arial', '', 11);
            $altura = $this->CalculateHeight(160, $texto);
            $y = 42 - ($altura * 3);
            $this->SetXY(40, $y);

            $this->SetAligns('J');
            $this->SetWidths(array(160));
            $this->PutRow(array($texto), true);


            $this->SetFont('Arial', '', 10);
            $this->SetXY(41, 42);
            $this->PutRow(array($this->transformacaoNumeroExtenso($valNota, false, true)));


            // Informações baixo
            $this->SetXY(41, 60);
            $this->Cell(0, 0, $_SESSION['nomClinica']);

            $this->SetXY(123, 60);
            $this->Cell(0, 0, date('d') . ' de ' . $this->transformacaoNomeMes(date('m')) . ' de ' . date('Y'));

            $this->SetXY(41, 67);
            $this->Cell(0, 0, $dtoClinica->getCodCpfCnpj());

            $this->SetXY(123, 67);
            $this->Cell(0, 0, $dtoClinica->getNomCidade() . ' - ' . strtoupper($dtoClinica->getCodUf()));

            $this->SetXY(41, 71);
            $this->SetWidths(array(70));
            $this->PutRow(array($dtoClinica->getStrEndereco()), true);

        }

        public function GerarCarne() {

            $this->Image('arquivos_impressao/carne-capa.jpg', 0, 0, 210, 41);

            $arrPaciente = new ModeloPaciente();
            $arrPaciente = $arrPaciente->getPaciente($this->dtoOrcamento->getCdnPaciente(), true);


            $this->SetFont('Arial', '', '14');
            $this->SetXY(30, 35.8);
            $this->Cell(0, 0, $arrPaciente['nomPaciente']);

            $this->SetFont('Arial', '', '22');
            $this->SetXY(30, 20);
            $this->Cell(0, 0, $_SESSION['nomClinica']);

            $arrParcelas = $this->arrParcelas;

            $totalParcelas = new Modelo();
            $totalParcelas = $totalParcelas->query('SELECT COUNT(cdnOrcamento) as qtd FROM orcamento_parcela WHERE
                                          cdnOrcamento = ' . $this->dtoOrcamento->getCdnOrcamento())[0]['qtd'];


            $temCapa = true;
            $cont = 1;

            foreach ($arrParcelas as $dtoParcela) {
                $dtoParcela = unserialize($dtoParcela);

                $yBase = 42 * $cont;

                $this->SetXY(0, $yBase);

                $this->Image('arquivos_impressao/carne-parcela.jpg', null, null, 210, 41);


                // Cabeçalho
                # Esquerda
                $this->SetXY(6.9, $yBase + 4.4);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 0, $_SESSION['nomClinica']);

                # Direita
                $this->SetFont('Arial', '', 14);
                $this->SetXY(68.2, $yBase + 4.4);
                $this->Cell(0, 0, $_SESSION['nomClinica']);

                // Informações esquerda
                $this->SetFont('Arial', '', 8);
                # Nome
                $this->SetXY(6.9, $yBase + 18.5);
                $this->Cell(0, 0, $arrPaciente['nomPaciente']);
                # Nro da parcela
                $this->SetXY(13.7, $yBase + 27.9);
                $this->Cell(0, 0, $dtoParcela->getNumParcela() . ' de ' . $totalParcelas);
                # Valor da parcela
                $this->SetXY(37.1, $yBase + 27.9);
                $this->Cell(0, 0, 'R$' . $dtoParcela->getValParcela(true));

                // Informações direita
                # Nome
                $this->SetXY(69.3, $yBase + 22.1);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 0, $arrPaciente['nomPaciente']);
                # Vencimento
                $this->SetXY(72.4, $yBase + 31.7);
                $this->Cell(0, 0, $dtoParcela->getDatVencimento(true));
                # Parcela
                $this->SetXY(106.6, $yBase + 31.7);
                $this->Cell(0, 0, $dtoParcela->getNumParcela() . ' de ' . $totalParcelas);
                # Valor da parcela
                $this->SetXY(132.7, $yBase + 31.7);
                $this->Cell(0, 0, 'R$' . $dtoParcela->getValParcela(true));
                # Valor Total
                $this->SetXY(168, $yBase + 31.7);
                $this->Cell(0, 0, 'R$' . $this->dtoOrcamento->getValFinal(true));


                $cont++;

                if ($temCapa) {
                    if ($cont == 7) {
                        $cont = 0;
                        $temCapa = false;
                        $this->AddPage();
                        $this->SetXY(0, 0);
                    }
                } else {
                    if ($cont == 7) {
                        $cont = 0;
                        $this->AddPage();
                        $this->SetXY(0, 0);
                    }
                }

            }

        }

        public function ImprimirOrcamento() {


            $modPaciente = new ModeloPaciente();
            $arrPaciente = $modPaciente->getPaciente($this->dtoOrcamento->getCdnPaciente(), true);
            $dtoOrcamento = $this->dtoOrcamento;

            // Título
            $this->SetFont('Arial', 'B', '14');
            $this->SetAligns(array('C'));
            $this->SetWidths(array(0));
            $this->PutRow(array('ORÇAMENTO - ' . $_SESSION['nomClinica']), true);
            $this->SetFont('Arial', '', '11');
            $this->PutRow(array('Gerado em: ' . date('d/m/Y')), true);
            if(!$dtoOrcamento->getIndAprovado())
                $this->PutRow(array('ORÇAMENTO SOB APROVAÇÃO PENDENTE'), true);
            else
                $this->PutRow(array('ORÇAMENTO APROVADO EM '. $dtoOrcamento->getDatAprovacao(true)), true);
            $this->Ln(10);


            // Nome de paciente e titular
            if (is_null($arrPaciente['cdnParceria'])) {
                $strParceria = 'Particular';
            } else {
                $arrParceria = $modPaciente->consultar('parceria', '*', array('cdnParceria' => $arrPaciente['cdnParceria']))[0];
                $strParceria = $arrParceria['nomParceria'];
            }

            $this->SetFont('Arial', '', '11');
            $this->SetMargins(10, 10);
            $this->SetAligns(array('L'));
            $this->SetWidths(array(0));
            $yIni = $this->GetY();
            $xIni = $this->GetX();
            $this->PutRow(array('Paciente: ' . $arrPaciente['nomPaciente']), true);
            $yFim = $this->GetY();
            $this->Rect(10, $yIni, 190, $yFim - $yIni);

            // Tipo e parceria
            $yIni = $this->GetY();
            $xIni = $this->GetX();
            $this->PutRow(array('Empresa: ' . $strParceria), true);
            $yFim = $this->GetY();
            $this->Rect(10, $yIni, 190, $yFim - $yIni);

            //datas
            $this->SetAligns(array('L', 'L'));
            $this->SetWidths(array(95, 95));
            $yIni = $this->GetY();
            $xIni = $this->GetX();
            if (!$dtoOrcamento->getIndAprovado()) {
                $this->PutRow(array('Data de criação: ' . $dtoOrcamento->getDatOrcamento(true),
                    'Data de vencimento: ' . $dtoOrcamento->getDatValidade(true)), true);
                $yFim = $this->GetY();
                $this->Rect(10, $yIni, 95, $yFim - $yIni);
                $this->Rect(105, $yIni, 95, $yFim - $yIni);
            } else {
                $this->PutRow(array('Data de criação: ' . $dtoOrcamento->getDatOrcamento(true), ''), true);
                $yFim = $this->GetY();
                $this->Rect(10, $yIni, 190, $yFim - $yIni);
            }

            // Cabeçalho
            $this->Ln(5);
            $this->SetWidths(array(30, 50, 35, 15, 30, 30));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));
            $this->SetBorders(array('LTRB', 'LTRB', 'LTRB', 'LTRB', 'LTRB', 'LTRB'));
            $this->SetFont('Arial', 'B', '11');
            $this->PutRow(array('Área', 'Procedimento - Dente', 'Dentista', 'Qtd.', 'Valor Unit.', 'Valor total'), true);

            // Procedimentos
            $modProcedimento = new ModeloProcedimento();
            $modAreaAtuacao = new ModeloAreaAtuacao();
            $modMain = new ModeloMain(true);
            $arrProcedimentos = $modProcedimento->consultar('orcamento_procedimento', '*', array('cdnOrcamento' => $dtoOrcamento->getCdnOrcamento()));
            $this->SetBorders(array('', '', '', '', '', '', ''));
            $this->SetFont('Arial', '', '11');
            $valorSomatorio = 0;
            foreach ($arrProcedimentos as $arrProcedimento) {
                $dtoProcedimento = $modProcedimento->getProcedimento($arrProcedimento['cdnProcedimento']);
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrProcedimento['cdnAreaAtuacao']);
                $arrDentista = $modMain->getUsuario($arrProcedimento['cdnDentista']);
                $yIni = $this->GetY();
                $xIni = $this->GetX();
                $valTotal = $arrProcedimento['valUnitario'] * $arrProcedimento['numQuantidade'];
                if (!is_null($arrProcedimento['numDente']) and trim($arrProcedimento['numDente']) != '')
                    $dente = ' - Dente: ' . $arrProcedimento['numDente'];
                else
                    $dente = '';
                $this->PutRow(array($dtoAreaAtuacao->getNomAreaAtuacao(),
                    $dtoProcedimento->getNomProcedimento() . $dente,
                    $arrDentista['nomUsuario'],
                    $arrProcedimento['numQuantidade'],
                    $this->transformacaoMonetario($arrProcedimento['valUnitario']),
                    $this->transformacaoMonetario($valTotal)), true);
                $yFim = $this->GetY();
                $this->Rect(10, $yIni, 30, $yFim - $yIni); // area
                $this->Rect(40, $yIni, 50, $yFim - $yIni); // procedimento
                $this->Rect(90, $yIni, 35, $yFim - $yIni); // dentista
                $this->Rect(125, $yIni, 15, $yFim - $yIni); // qtd
                $this->Rect(140, $yIni, 30, $yFim - $yIni); // val unit.
                $this->Rect(170, $yIni, 30, $yFim - $yIni); // val tot.
                $valorSomatorio += $valTotal;
            }
            $yIni = $this->GetY();
            $xIni = $this->GetX();


            // Valor final
            $this->SetWidths(array(30, 50, 35, 45, 30));
            $this->SetAligns(array('C', 'C', 'C', 'R', 'C'));
            $this->PutRow(array('', '', '', 'Valor final:', $dtoOrcamento->getValOrcamento(true)), true);
            $yFim = $this->GetY();
            $this->Rect(10, $yIni, 190, $yFim - $yIni);
            $this->Rect(140, $yIni, 30, $yFim - $yIni); // val unit.
            // $this->Rect(170, $yIni, 30, $yFim - $yIni); // val tot.

            if ($this->dtoOrcamento->getIndAprovado()) {
                $this->ImprimirOrcamentoAprovado();
                return;
            }

            // Forma de pagamento
            $this->Ln(5);
            if($dtoOrcamento->getIndCobrarJuros()){
                $modMain = new ModeloMain(true);
                $dtoConfiguracoes = $modMain->getConfiguracoes();
                $taxa = $dtoConfiguracoes->getValJurosOrcamento();
            }else{
                $taxa = 0;
            }
            $this->SetWidths(array(($this->w - 20) / 4, ($this->w - 20) / 4, ($this->w - 20) / 4, ($this->w - 20) / 4));
            $this->SetAligns(array('C', 'C', 'C', 'C'));
            $this->SetFont('Arial', 'B', 11);
            $this->PutRow(array('Parcelas', 'Valores de parcelas', 'Valor', 'Taxas'), true);
            $this->SetFont('Arial', '', 11);
            $this->Line($this->GetX(), $this->GetY(), $this->w - 10, $this->GetY());
            for ($i = 1; $i <= 6; $i++) {
                $valor = $dtoOrcamento->getValOrcamento();
                if($i != 1) {
                    $valor = floatval($valor) * pow((1 + floatval($taxa) / 100), $i);

                    $parcelas = array(
                        'unica' => 0,
                        'geral' => 0,
                        'vezes' => 0,
                    );

                    $soma = 0;
                    for ($j = 1; $j < $i; $j++) {
                        $valorMes = $valor / $i;
                        $valorMes = round($valorMes, 2);
                        $parcelas['geral'] = $valorMes;
                        $soma = $soma + $valorMes;
                    }
                    $valorMes = $valor - $soma;
                    $valorMes = round($valorMes, 2);
                    $parcelas['unica'] = $valorMes;
                    if ($parcelas['unica'] != $parcelas['geral']) {
                        $parcelas['vezes'] = $i - 1;
                        $texto = $parcelas['vezes'] . 'x de R$' . number_format($parcelas['geral'], 2, ',', '.') . ' + 1x de R$' . number_format($parcelas['unica'], 2, ',', '.');
                    } else {
                        $parcelas['vezes'] = $i;
                        $texto = $parcelas['vezes'] . 'x de R$' . number_format($parcelas['geral'], 2, ',', '.');
                    }
                }else{
                    $texto = '1x de R$'.number_format($valor, 2, ',', '.');
                }
                $valTaxas = number_format($valor - $dtoOrcamento->getValOrcamento(), 2, ',', '.');
                $this->PutRow(array($i, $texto, 'R$' . number_format($valor, 2, ',', '.'), 'R$' . ($valTaxas)), true);
                $this->Ln(5);
            }
            // Observações
            if (!is_null($dtoOrcamento->getDesOrcamento())) {
                $this->SetFont('Arial', '', '11');
                $this->SetAligns(array('L'));
                $this->SetWidths(array(0));
                $this->PutRow(array('Observações:'), true);
                $this->SetBorders(array('LRBT'));
                $this->PutRow(array($dtoOrcamento->getDesOrcamento()), true);
            }


        }

        public function ImprimirOrcamentoAprovado(){
            $yIni = $this->GetY();
            $xIni = $this->GetX();

            $dtoOrcamento = $this->dtoOrcamento;
            $modOrcamento = new ModeloOrcamento();
            $dtoOrcamentoFormaPagamento = $modOrcamento->getOrcamentoFormaPagamento($dtoOrcamento->getCdnOrcamento());
            $forma = $dtoOrcamentoFormaPagamento->getIndForma(true);
            $this->SetWidths(array(0));
            $this->SetAligns(array('L'));
            $this->PutRow(array('Forma de pagamento: ' . $forma), true);





            if ($forma == 'Parcelado') {
                $this->SetWidths(array(($this->w - 20) / 4, ($this->w - 20) / 4, ($this->w - 20) / 4, ($this->w - 20) / 4));
                $this->SetAligns(array('C', 'C', 'C', 'C'));
                $this->SetFont('Arial', 'B', 11);
                $this->PutRow(array('Parcela', 'Valor', 'Vencimento', 'Paga'), true);
                $this->SetFont('Arial', '', 11);
                $this->Ln(2);
                foreach ($this->arrParcelas as $dtoParcela) {
                    $dtoParcela = unserialize($dtoParcela);
                    $this->PutRow(array(
                        $dtoParcela->getNumParcela(),
                        $dtoParcela->getValParcela(true),
                        $dtoParcela->getDatVencimento(true),
                        $dtoParcela->getIndPaga(true),
                    ), true);
                    $this->Ln(2);
                }
                // Valor final
                $this->Ln(5);
                $this->SetFont('Arial', 'B', '12');
                $this->SetAligns(array('C', 'C', 'R', 'C'));
                $this->PutRow(array('Valor final (c/ taxas):', $dtoOrcamento->getValFinal(true), '', ''), true);
                $this->Ln(5);
            } else {
                $via = $dtoOrcamentoFormaPagamento->getIndVia(true);
                $valorFinal = $dtoOrcamento->getValFinal(true);
                $this->PutRow(array($via.' - 1x de '.$valorFinal), true);
                $this->PutRow(array('DATA DE PAGAMENTO: '.$dtoOrcamentoFormaPagamento->getDatInicioPagamento(true)), true);
            }

            $yFim = $this->GetY();
            $this->Rect(10, $yIni, 190, $yFim - $yIni);
            $this->Ln(5);

        }

        public function RelatorioAprovados($arrOrcamentos, $periodo){

            $this->SetFont('Arial', '', '10');
            $this->SetBorders(array('', '', '', '', ''));
            $this->SetWidths(array(15, 60, 50, 40, 25));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));

            $sobrenome = false;
            if(ControleCampo::campoExiste('nomSobrenome'))
                $sobrenome = true;
            foreach($arrOrcamentos as $arrOrcamento){
                if($sobrenome)
                    $arrOrcamento['nomPaciente'].= ' '.$arrOrcamento['nomSobrenome'];
                $this->PutRow(array(
                    $arrOrcamento['cdnOrcamento'],
                    $arrOrcamento['nomPaciente'],
                    'R$'.$this->transformacaoMonetario($arrOrcamento['valOrcamento']).' - '.
                         $this->transformacaoOrcamentoVia($arrOrcamento['indVia']),
                    $arrOrcamento['nomUsuario'],
                    $this->transformacaoData($arrOrcamento['datAprovacao']),
                ), true);

            }

        }

        public function RelatorioReprovados($arrOrcamentos, $periodo){

            $this->SetFont('Arial', '', '10');
            $this->SetBorders(array('', '', '', '', ''));
            $this->SetWidths(array(15, 60, 40, 50, 25));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));

            $sobrenome = false;
            if(ControleCampo::campoExiste('nomSobrenome'))
                $sobrenome = true;
            foreach($arrOrcamentos as $arrOrcamento){
                if($sobrenome)
                    $arrOrcamento['nomPaciente'].= ' '.$arrOrcamento['nomSobrenome'];
                $this->PutRow(array(
                    $arrOrcamento['cdnOrcamento'],
                    $arrOrcamento['nomPaciente'],
                    'R$'.$this->transformacaoMonetario($arrOrcamento['valOrcamento']),
                    $this->transformacaoOrcamentoVia($arrOrcamento['indVia']),
                    $this->transformacaoData($arrOrcamento['datAprovacao']),
                ), true);

            }

        }

    }
