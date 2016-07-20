<?php

    class PDFTabelaPreco extends FPDF {
        use PDF_trait;

        private $nomTabelaPreco;

        public function Header() {

            $aligns = $this->GetAligns();
            $widths = $this->GetWidths();

            $this->SetFont('Arial', '', 14);
            $this->SetAligns(array('L'));
            $this->SetBorders(array('B'));
            $this->SetWidths(array(0));

            $this->PutRow(array('Tabela de preço: '.$this->nomTabelaPreco));

            $this->SetAligns($aligns);
            $this->SetWidths($widths);
            $this->SetBorders(array());

            
        }

        /**
         * Método responsável pela definição do rodapé da página
         *
         **/
        public function Footer() {
            $this->SetFont('Arial', '', 8);
            $this->SetY(-30);
            $this->Cell(0, 30, 'Página ' . $this->PageNo() . ' de {nb}', '', 0, 'R');
        }

        public function setNomTabelaPreco($nome){
            $this->nomTabelaPreco = $nome;
        }
    }