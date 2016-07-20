<?php

    /**
     * Classe responsável pelo relatório financeiro
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-05-06
     *
    **/

    class PDFBoleto extends FPDF{
        use PDF_trait;

        private $widths;
        private $aligns;
        private $borders;
        private $companhia;

        /**
         * Método responsável pela definição do cabecalho da página
         *
         *
        **/
        public function Header(){
            $this->SetAligns(array('C'));
            $this->SetWidths(array(0));
            $this->SetFont('Arial', 'B', 16);
            $this->PutRow(array('BOLETO BANCÁRIO - '.$this->GetCompanhia()));
        }

        /**
         * Método responsável pela definição do rodapé da página
         *
        **/
        public function Footer(){
            $this->SetFont('Arial', 'B', 12);
            $this->SetY(-30);
            $this->Cell(0,30,'Sistema Fly - Página '.$this->PageNo().' de {nb}','T',0,'R');
        }

        /**
         * Método responsável por setar o nome da companhia
         *
         * @param String $companhia - nome da companhia
         *
        **/
        public function SetCompanhia($companhia){
            $this->companhia = $companhia;
        }

        /**
         * Método responsável por retornar o nome da companhia
         *
         * @return String - nome da companhia
         *
        **/
        public function GetCompanhia(){
            return $this->companhia;
        }
    }
