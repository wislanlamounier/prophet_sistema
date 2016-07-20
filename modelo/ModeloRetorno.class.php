<?php

    class ModeloRetorno extends Modelo{
        use Transformacao; 
        public function retornoMontaSql(){
            $ano = isset($_POST['ano']) ? $_POST['ano'] : date('Y');
            $mes = isset($_POST['mes']) ? $_POST['mes'] : date('m');
            $dentista = isset($_POST['dentista']) ? $_POST['dentista'] : null;
            $cdnPaciente = isset($_POST['cdnPaciente']) ? $_POST['cdnPaciente'] : null;
            
            $sql = '
                SELECT * FROM retorno r
                JOIN consulta c ON c.cdnConsulta = r.cdnConsultaRetorno
                JOIN paciente p ON p.cdnPaciente = c.cdnPaciente
                JOIN prophet_main.usuario u ON u.cdnUsuario = c.cdnDentista
            ';
            
            $sql .= ' WHERE ';
            
            
            if(ModeloUsuario::dentista($_SESSION['cdnUsuario'])){
                if(!ModeloUsuario::masterStatic($_SESSION['cdnUsuario'])){
                    $sql .= 'u.cdnUsuario = '.$_SESSION['cdnUsuario'].' AND ';
                }else{
                    if(!is_null($dentista) and trim($dentista) != '')
                        $sql .= 'u.cdnUsuario = '.$dentista.' AND ';
                }
            }else{
                if(!is_null($dentista) and trim($dentista) != '')
                    $sql .= 'u.cdnUsuario = '.$dentista.' AND ';
            }

            if($mes == 'todos'){
                $sql .= 'c.datConsulta >= "'.$ano.'-01-01 00:00:00" AND
                         c.datConsulta <= "'.$ano.'-12-31 23:59:59" AND ';
            }else{
                $sql .= 'c.datConsulta >= "'.$ano.'-'.$mes.'-01 00:00:00" AND
                         c.datConsulta <= "'.$ano.'-'.$mes.'-'.date('t').' 23:59:59" AND ';
            }


            if(!is_null($cdnPaciente) and trim($cdnPaciente) != ''){
                $sql .= 'c.cdnPaciente = '.$cdnPaciente;
            }
            
            return trim($sql, ' AND');
        }
        
        public function retornoImprimirFim($arrConsultas){
            
            $ano = isset($_POST['ano']) ? $_POST['ano'] : date('Y');
            $mes = isset($_POST['mes']) ? $_POST['mes'] : date('m');
            $dentista = isset($_POST['dentista']) ? $_POST['dentista'] : null;
            $paciente = isset($_POST['cdnPaciente']) ? $_POST['cdnPaciente'] : null;
            
            if(!is_null($dentista) and trim($dentista) != ''){
                $modMain = new ModeloMain(true);
                $dentista = $modMain->getUsuario($dentista);
            }else{
                $dentista = null;
            }
            
            if(!is_null($paciente) and trim($paciente) != ''){
                $modPaciente = new ModeloPaciente();
                $paciente = $modPaciente->getPaciente($cdnPaciente, true);
            }else{
                $paciente = null;
            }
            
            $arrCond = array(
                'ano' => $ano,
                'mes' => $mes,
                'dentista' => $dentista,
                'paciente' => $paciente
            );
            
            $pdfRetorno = new PDFRetorno('P', 'mm');
            $pdfRetorno->SetWidths(array(47.5, 47.5, 47.5, 47.5));
            $pdfRetorno->SetBorders(array('', '', '', ''));
            $pdfRetorno->SetAligns(array('L', 'L', 'L', 'L'));
            $pdfRetorno->AliasNbPages();
            $pdfRetorno->SetCond($arrCond);
            $pdfRetorno->AddPage();
            
            
            foreach($arrConsultas as $arrConsulta){
                if(isset($arrConsulta['nomSobrenome']))
                    $arrConsulta['nomPaciente'] .= ' '.$arrConsulta['nomSobrenome'];
                if(isset($arrConsulta['numTelefone2']))
                    $arrConsulta['numTelefone1'] .= ' '.$arrConsulta['numTelefone2'];
                if(isset($arrConsulta['numProntuarioAntigo']))
                    $arrConsulta['cdnPaciente'] .= ' - '.$arrConsulta['numProntuarioAntigo'];
                
                $pdfRetorno->PutRow(array(
                    $arrConsulta['nomPaciente'].' - '.$arrConsulta['numTelefone1'],
                    $arrConsulta['cdnPaciente'],
                    $arrConsulta['nomUsuario'],
                    $this->transformacaoData($arrConsulta['datConsulta']).' '.$arrConsulta['horaConsulta'],
                ), true);
            }
            
            $pdfRetorno->OutPut();
            
        }
    }