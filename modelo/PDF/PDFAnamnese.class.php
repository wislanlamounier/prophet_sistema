<?php

	/**
	 * Classe responsável pela impressão da anamnese de um paciente
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-01
	 *
	**/
	class PDFAnamnese extends FPDF{
		use PDF_trait;

    	/**
         * Método responsável pela definição do cabecalho da página
         *
         *
        **/
        public function Header(){

            $aligns = $this->GetAligns();
            $widths = $this->GetWidths();

            $this->SetFont('Arial', '', 14);
            $this->SetAligns('J');
            $this->SetWidths(0);
            $this->PutRow(array($_SESSION['nomClinica']), true);

            $this->SetAligns(array('J', 'J', 'J'));
            $this->SetWidths(array(10, 130, 50));
            $this->SetFont('Arial', '', 11);
            $this->SetBorders(array('B', 'B', 'B'));
            $this->PutRow(array(' ',
                                'Prontuário número: '.$this->arrPaciente['cdnPaciente'],
                                'Data: '.date('d/m/Y')), true);

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
         * Método responsável por setar o array do paciente
         *
         * @param Array $arrPaciente - paciente
         *
        **/
        public function setArrPaciente($arrPaciente){
            $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? $arrPaciente['nomSobrenome'] : '';
            $this->arrPaciente = $arrPaciente;
        }

        /**
         * Método responsável por retornar o array do paciente
         *
         * @return Array - array do paciente
         *
        **/
        public function getArrPaciente(){
            return $this->arrPaciente;
        }
	}