<?php

    /**
     * Classe responsável pela impressão do prontuario de um paciente
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-31
     *
     * */
    class PDFProntuario extends FPDF {

        use PDF_trait;

        private $arrPaciente;

        /**
         * Método responsável pela definição do cabecalho da página
         *
         *
         * */
        public function Header() {

            $aligns = $this->GetAligns();
            $widths = $this->GetWidths();
            $borders = $this->GetBorders();

            $this->SetFont('Arial', '', 10);
            $this->SetWidths(array(25, 165));

            $yIni = $this->GetY();
            $this->PutRow(array('NOME: ', $this->arrPaciente['nomPaciente']), true);
            $yFim = $this->GetY();
            $this->Rect(35, $yIni, $this->w - 45, $yFim - $yIni);
            $this->Rect(10, $yIni, 25, $yFim - $yIni);

            $strEndereco = isset($this->arrPaciente['strEndereco']) ? $this->arrPaciente['strEndereco'] : '';
            $strEndereco .= isset($this->arrPaciente['nomBairro']) ? ' ' . $this->arrPaciente['nomBairro'] : '';
            $strEndereco .= isset($this->arrPaciente['nomCidade']) ? ' ' . $this->arrPaciente['nomCidade'] : '';

            $yIni = $this->GetY();
            $this->PutRow(array('ENDEREÇO: ', $strEndereco), true);
            $yFim = $this->GetY();
            $this->Rect(35, $yIni, $this->w - 45, $yFim - $yIni);
            $this->Rect(10, $yIni, 25, $yFim - $yIni);

            $this->SetWidths(array(25, 118, 25, 22));

            $strTelefones = isset($this->arrPaciente['strTelefone']) ? $this->arrPaciente['strTelefone'] : '';
            $strTelefones = isset($this->arrPaciente['strTelefone1']) ? ' ' . $this->arrPaciente['strTelefone1'] : '';
            $strTelefones = isset($this->arrPaciente['strTelefone2']) ? ' ' . $this->arrPaciente['strTelefone2'] : '';

            $datNascimento = isset($this->arrPaciente['datNascimento']) ? $this->arrPaciente['datNascimento'] : '';
            if ($datNascimento != '') {
                $datNascimento = explode('-', $datNascimento);
                $datNascimento = $datNascimento[2] . '/' . $datNascimento[1] . '/' . $datNascimento[0];
            }
            $yIni = $this->GetY();
            $this->PutRow(array('TELEFONE: ', $strTelefones, 'DATA NASC.: ', $datNascimento), true);
            $yFim = $this->GetY();
            $this->Rect(35, $yIni, 118, $yFim - $yIni);
            $this->Rect(153, $yIni, 25, $yFim - $yIni);
            $this->Rect(178, $yIni, 22, $yFim - $yIni);
            $this->Rect(10, $yIni, 25, $yFim - $yIni);

            $this->SetFont('Arial', 'B', 10);
            $this->SetWidths(array(5, 20, 100, 65));
            $this->SetAligns(array('C', 'C', 'J', 'J'));
            $this->SetBorders(array('B', 'B', 'B', 'B'));
            $this->PutRow(array('', 'Dente', 'Tratamento realizado', 'Dentista'), true);

            $this->SetWidths($widths);
            $this->SetAligns($aligns);
            $this->SetBorders($borders);
        }

        /**
         * Método responsável pela definição do rodapé da página
         *
         * */
        public function Footer() {
            $this->SetFont('Arial', 'B', 11);
            $this->SetY(-10);
            $this->Cell(0, 10, 'Assinatura do paciente', 'T', 0, 'C');
        }

        /**
         * Método responsável por setar o array do paciente
         *
         * @param Array $arrPaciente - paciente
         *
         * */
        public function setArrPaciente($arrPaciente) {
            $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? $arrPaciente['nomSobrenome'] : '';
            $this->arrPaciente = $arrPaciente;
        }

        /**
         * Método responsável por retornar o array do paciente
         *
         * @return Array - array do paciente
         *
         * */
        public function getArrPaciente() {
            return $this->arrPaciente;
        }

    }
    