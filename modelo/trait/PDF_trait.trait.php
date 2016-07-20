<?php
trait PDF_trait{
    private $widths;
    private $aligns;
    private $borders;
    private $angle;

    /**
     * Método responsável por adicionar uma label na página
     *
     * @param String $desLabel - label a ser adicionada
     *
    **/
    public function AddLabel($desLabel){
        $this->SetFont('Courier', 'B', 12);
        $this->Cell($this->GetStringWidth($desLabel) + 5 , 20, $desLabel, 0, 0, 'L');
    }

    /**
     * Método responsável por adicionar um texto na página
     *
     * @param String $desTexto - texto a ser adicionado
     *
    **/
    public function AddText($desTexto){
        $this->SetFont('Courier', '', 12);
        $this->Write(20, $desTexto.'   ');
    }

    /**
     * Método responsável por adicionar uma imagem na página
     *
     * @param String $desCaminhoImagem - caminho da imagem
     *
    **/
    public function AddImage($desCaminhoImagem){
        $this->Image($desCaminhoImagem, null, null, 100);
    }

    /**
     * Método responsável por setar o texto da header da página
     *
     * @param String $header - header
     *
    **/
    public function SetHeader($header){
        $this->TextHeader = $header;
    }

    /**
     * Método responsável por setar o texto da footer da página
     *
     * @param String $footer - footer
     *
    **/
    public function SetFooter($footer){
        $this->TextFooter = $footer;
    }

    /**
     * Método responsável por setar a largura das colunas
     *
     * @param Array $widths - array de widths
     *
    **/
    function SetWidths($widths){
        $this->widths = $widths;
    }

    /**
     * Método responsável por retornar a largura das colunas
     *
     * @return Array - largura das colunas
     *
    **/
    public function GetWidths(){
        return $this->widths;
    }

    /**
     * Método responsável por setar o alinhamento dos textos nas colunas
     *
     * @param Array $aligns - array de aligns
     *
    **/
    function SetAligns($aligns){
        $this->aligns=$aligns;
    }

    /**
     * Método responsável por retornar os alinhamentos
     *
     * @return Array - alinhasmentos dos textos
     *
    **/
    public function GetAligns(){
        return $this->aligns;
    }


    /**
     * Método responsável por setar as bordas das células
     *
     * @param Array $borders - bordas
     *
    **/
    function SetBorders($borders){
        $this->borders = $borders;
    }

    /**
     * Método responsável por retornar as bordas
     *
     * @return Array - bordas
     *
    **/
    public function GetBorders(){
        return $this->borders;
    }

    /**
     * Método responsável por colocar uma linha da tabela na página
     *
     * @param Array $data - dados da linha
     * @param Boolean $mm - indicador se está em mm ou pt
     * @link http://www.fpdf.org/en/script/script3.php
     *
    **/
    function PutRow($data, $mm = false){
    // 	//Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++){
             $nb= max($nb, $this->NbLines($this->widths[$i], $data[$i]));
         }
        //  echo $nb.'<br />';
        if($mm)
        	$h = 5 * $nb;
        else
        	$h= 10 * $nb;

        //Issue a page break first if needed
        $this->CheckPageBreak($h, $mm);

        //Draw the cells of the row
        for($i=0;$i<count($data);$i++){
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'J';
            $b=isset($this->borders[$i]) ? $this->borders[$i] : 0;
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Print the text
            if($mm)
            	$this->MultiCell($w,5,$data[$i],$b, $a);
            else
            	$this->MultiCell($w,15,$data[$i],$b, $a);

            //Put the position to the right of the cell

            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        if($mm){
            $this->Ln($h);
        }else{
	        if($h > 15)
	            $this->Ln($h + 20);
	        else
	            $this->Ln($h + 10);
        }
    }

    /**
     * Método responsável por calcular se deve adicionar uma nova página ou não
     *
     * @param Integer $height - altura atual da página
     * @param Boolean $mm - medindo em milímetros
     * @return Boolean - true if break, false if not
     *
    **/
    function CheckPageBreak($height, $mm = false){
        //If the height h would cause an overflow, add a new page immediately
        if($mm){
            if($this->GetY() + $height > $this->PageBreakTrigger){
                $this->AddPage($this->CurOrientation);
                return true;
            }
        }else{
	        if($height > 15){
	            if($this->GetY() + ($height + ($height * 2)) > $this->PageBreakTrigger){
	                $this->AddPage($this->CurOrientation);
	                return true;
	            }
	        }else{
	            if($this->GetY() + $height + 30 > $this->PageBreakTrigger){
	                $this->AddPage($this->CurOrientation);
	                return true;
	            }
	        }
        }
    }

    /**
     * Método responsável por calcular o número de linhas que uma célula adicionada
     * irá ocupar
     *
     * @param Integer $width - width da celula
     * @param String $text - texto
     *
    **/
    function NbLines($w,$txt){
        if($this->GetStringWidth($txt) + 5 < $w)
            return 1;
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax){
                if($sep==-1){
                    if($i==$j)
                        $i++;
                }else{
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }else{
                $i++;
            }
        }
        return $nl;
    }

    public function CalculateHeight($width, $txt){
        $cw = &$this->CurrentFont['cw'];
        if($width == 0)
            $width = $this->w-$this->rMargin-$this->x;

        $maxwidth = ($width - 2 * $this->cMargin) * 1000 / $this->FontSize;

        $string = str_replace("\r", '', $txt);

        $totalwidth = ($this->GetStringWidth($string) - 2 * $this->cMargin) * 1000 / $this->FontSize;

        if($maxwidth > $totalwidth)
            return 1;
        else
            return ceil($totalwidth / $maxwidth) + 1;
    }

    public function BreakLines($width, $txt, $b, $a){
        $cw = &$this->CurrentFont['cw'];
        if($width == 0)
            $width = $this->w-$this->rMargin-$this->x;

        $maxwidth = ($width - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $string = str_replace("\r", '', $txt);
        $array = str_split($txt);

        $totalwidth = ($this->GetStringWidth($string) - 2 * $this->cMargin) * 1000 / $this->FontSize;

        if($totalwidth < $maxwidth)
            return $txt;
        $lines = ceil($totalwidth / $maxwidth) + 1;

        $maxlinewidth = ceil($totalwidth / $lines);
        $str = '';
        $finalstr = '';
        for($i = 0; $i < count($array); $i++){
            $str .= $array[$i];
            $currentwidth = ($this->GetStringWidth($str) - 2 * $this->cMargin) * 1000 / $this->FontSize;
            if(($currentwidth) >= $maxlinewidth){
                $this->Cell($width, 15, $str, $b, 2, $a);
                $str = '';
                $this->Ln(15);
            }
            if($i == count($array) - 1 and ($currentwidth + 15) <= $maxlinewidth){
                $this->Cell($width, 15, $str, $b, 2, $a);
                $str = '';
                $this->Ln(15);
            }
        }
        return $finalstr;

    }


    public function Rotate($angle,$x=-1,$y=-1){
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    public function RotatedText($x,$y,$txt,$angle){
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

}
