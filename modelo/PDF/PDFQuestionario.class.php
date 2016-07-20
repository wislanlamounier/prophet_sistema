<?php

	/**
	 * Classe responsável pela impressão do questionário anamnese
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-01
	 *
	**/
	class PDFQuestionario extends FPDF{
		use PDF_trait;

    	/**
         * Método responsável pela definição do cabecalho da página
         *
         *
        **/
        public function Header(){

            $this->SetFont('Arial', 'B', 12);
            $this->SetAligns('C');
            $this->SetWidths(0);

            $this->PutRow(array('Questionário de Saúde - '.$_SESSION['nomClinica']));

            $this->SetFont('Arial', '', 10);
            $this->SetAligns('J');
            
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
	}