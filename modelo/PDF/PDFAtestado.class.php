<?php

	/**
	 * Classe responsável pela impressão do atestado
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-29
	 *
	**/
	class PDFAtestado extends FPDF{
		use PDF_trait;

    	/**
         * Método responsável pela definição do cabecalho da página
         *
         *
        **/
        public function Header(){

        }

        /**
         * Método responsável pela definição do rodapé da página
         *
        **/
        public function Footer(){
            // $this->SetFont('Arial', 'B', 11);
            // $this->SetY(-10);
            // $this->Cell(0,10,'Assinatura do paciente','T',0,'C');
        }


	}