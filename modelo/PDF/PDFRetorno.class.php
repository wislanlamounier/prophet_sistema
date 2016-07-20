<?php

    class PDFRetorno extends FPDF {

        use PDF_trait;
        use Transformacao;
        
        private $arrCond;
        private $nomeMes;
        private $arrDentista;
        private $arrPaciente = null;
        private $nomDentista = 'Todos';
        
        public function Header() {
            
            $aligns = $this->GetAligns();
            $widths = $this->GetWidths();
            $borders = $this->GetBorders();

            $this->SetFont('Arial', 'B', 12);
            $this->SetAligns(array('C'));
            $this->SetWidths(array(0));
            $this->PutRow(array('Agenda de retornos - '.$this->nomeMes.' de '.$this->arrCond['ano']), true);

            $yIni = $this->GetY();
            $this->SetFont('Arial', '', 12);
            $this->SetAligns(array('L', 'L', 'L', 'L'));
            $this->SetWidths(array(20, 80, 20, 70));
            $this->PutRow(array('Clinica: ', $_SESSION['nomClinica'], 'Dentista:', $this->nomDentista), true);
            $yFim = $this->GetY();
            $this->Rect(10, $yIni, 20, $yFim - $yIni);
            $this->Rect(30, $yIni, 80, $yFim - $yIni);
            $this->Rect(110, $yIni, 20, $yFim - $yIni);
            $this->Rect(130, $yIni, 70, $yFim - $yIni);

            $this->Ln(5);
            
            if(!is_null($this->arrPaciente)){
                $this->SetAligns(array('L'));
                $this->SetWidths(array('0'));
                $this->SetBorders(array('B'));
                $this->PutRow(array('Paciente: '.$this->arrPaciente['nomPaciente']), true);
                $this->Ln(5);
            }
            
            $this->SetFont('Arial', '', 10);
            $this->SetWidths(array(47.5, 47.5, 47.5, 47.5));
            $this->SetBorders(array('', '', '', ''));
            $this->SetAligns(array('L', 'L', 'L', 'L'));
            $this->PutRow(array('Paciente - Telefone', 'Prontuário (novo-antigo)', 'Dentista', 'Data'), true);
            $this->Line(10, $this->GetY(), 200, $this->GetY());

            $this->SetWidths($widths);
            $this->SetAligns($aligns);
            $this->SetBorders($borders);
        }
        
        public function Footer() {
            
        }

        public function SetCond($arrCond){
            $this->arrCond = $arrCond;
            $this->nomeMes = $this->transformacaoNomeMes($arrCond['mes']);
            $this->arrDentista = $arrCond['dentista'];
            if(!is_null($this->arrDentista)){
                $this->nomDentista = $this->arrDentista['nomUsuario'];
            }
            $this->arrPaciente = $arrCond['paciente'];
        }
    }
    