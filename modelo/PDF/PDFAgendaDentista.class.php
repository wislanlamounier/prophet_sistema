<?php

	/**
	 * Classe responsável pela impressão da agenda por dentista
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-10-06
	 *
	**/
	class PDFAgendaDentista extends FPDF{
		use PDF_trait;
        use Transformacao;
        private $datConsulta;

    	/**
         * Método responsável pela definição do cabecalho da página
         *
         *
        **/
        public function Header(){

            $aligns = $this->GetAligns();
            $widths = $this->GetWidths();

            $this->SetFont('Arial', 'B', 12);
            $this->SetAligns(array('C'));
            $this->SetWidths(array(0));
            $this->PutRow(array('Agenda do dia '.$this->getDatConsulta(true)), true);

            $yIni = $this->GetY();
            $this->SetFont('Arial', '', 12);
            $this->SetAligns(array('L', 'L', 'L', 'L'));
            $this->SetWidths(array(20, 105, 15, 50));
            $this->PutRow(array('Clinica: ', $_SESSION['nomClinica'], 'Tipo:', 'Por dentista'), true);
            $yFim = $this->GetY();
            $this->Rect(10, $yIni, 20, $yFim - $yIni);
            $this->Rect(30, $yIni, 105, $yFim - $yIni);
            $this->Rect(135, $yIni, 15, $yFim - $yIni);
            $this->Rect(150, $yIni, 50, $yFim - $yIni);

            $this->Ln(5);

            $this->SetAligns($aligns);
            $this->SetWidths($widths);
            $this->SetBorders(array());

            
        }

        /**
         * Método responsável pela definição do rodapé da página
         *
        **/
        public function Footer(){
            $this->SetFont('Arial', '', 8);
            $this->SetY(-30);
            $this->Cell(0,30,'Página '.$this->PageNo().' de {nb}','',0,'R');
        }

        /**
         * Método responsável por setar a data da consulta
         *
         * @param String $datConsulta - data da consulta
         *
        **/
        public function setDatConsulta($datConsulta){
            $this->datConsulta = $datConsulta;
        }

        /**
         * Método responsável por retornar a data da consulta
         *
         * @return String - data da consulta
         *
        **/
        public function getDatConsulta(){
            return $this->datConsulta;
        }

	}