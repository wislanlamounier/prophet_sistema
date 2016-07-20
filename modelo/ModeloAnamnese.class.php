<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a anamnese.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-01
     *
    **/
    class ModeloAnamnese extends Modelo{
    	use Transformacao;

    	/**
         * Método responsável por finalizar o cadastro de respostas no questionário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         *
        **/
        public function anamneseResponderFim($cdnPaciente){
            $arrPerguntas = $this->consultar('pergunta');
            $arrComOpcoes = array();

            $this->deletar('resposta', array('cdnPaciente' => $cdnPaciente));

            foreach($arrPerguntas as $arrPergunta){
                $dtoResposta = new DTOResposta();
                if(!$this->checaExiste('pergunta_opcao', 'cdnPergunta', $arrPergunta['cdnPergunta'])){
                    $strResposta = $_POST[$arrPergunta['cdnPergunta']];

                    $dtoResposta->setStrResposta($strResposta);
                    $dtoResposta->setCdnPaciente($cdnPaciente);
                    $dtoResposta->setCdnPergunta($arrPergunta['cdnPergunta']);

                    $arrDados = $dtoResposta->getArrayBanco();
                    $this->inserir('resposta', $arrDados);
                }else{
                    $arrOpcoes = $this->consultar('pergunta_opcao', '*', array('cdnPergunta' => $arrPergunta['cdnPergunta']));
                    foreach($arrOpcoes as $arrOpcao){
                        if(isset($_POST['op'.$arrOpcao['cdnOpcao']])){
                            $dtoResposta->setCdnOpcao($arrOpcao['cdnOpcao']);
                            $dtoResposta->setCdnPergunta($arrOpcao['cdnPergunta']);
                            $dtoResposta->setCdnPaciente($cdnPaciente);

                            $arrDados = $dtoResposta->getArrayBanco();
                            $this->inserir('resposta', $arrDados);
                        }
                    }
                }
            }
        }

        /**
         * Método responsável pela impressão da anamnese
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void
         *
        **/
        public function anamneseImprimir($cdnPaciente){
            $pdfAnamnese = new PDFAnamnese('P', 'mm');
            $modPaciente = new ModeloPaciente();
            $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
            $pdfAnamnese->setArrPaciente($arrPaciente);

            $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' '.$arrPaciente['nomSobrenome'] : '';

            $pdfAnamnese->AddPage();
            $pdfAnamnese->AliasNbPages();

            $pdfAnamnese->SetBorders(array('', '', ''));
            $pdfAnamnese->SetFont('Arial', '', 10);


            $pdfAnamnese->SetAligns(array('C'));
            $pdfAnamnese->SetWidths(array(0));
            $pdfAnamnese->SetBorders(array(''));
            $pdfAnamnese->PutRow(array('IDENTIFICAÇÃO DO PACIENTE'), true);

            $pdfAnamnese->SetBorders(array());

            
            $modCampo = new ModeloCampo();
            $arrCampos = $modCampo->consultar('anamnese_campo');

            $pdfAnamnese->SetAligns(array('J', 'J', 'J', 'J'));

            $pdfAnamnese->SetWidths(array(30, 95, 25, 40));


            if($this->checaExiste('schema_campo', 'nomCampo', 'codCpf')){
                $labelCod = 'CPF';
                $valCod = $arrPaciente['codCpf'];
            }

            if($this->checaExiste('schema_campo', 'nomCampo', 'codCnpj')){
                $labelCod = 'CNPJ';
                $valCod = $arrPaciente['codCnpj'];
            }

            if($this->checaExiste('schema_campo', 'nomCampo', 'codCpfCnpj')){
                $labelCod = 'CPF/CNPJ';
                $valCod = $arrPaciente['codCpfCnpj'];
            }

            $yIni = $pdfAnamnese->GetY();
            $pdfAnamnese->PutRow(array('Nome', $arrPaciente['nomPaciente'], $labelCod, $valCod), true);
            $yFim = $pdfAnamnese->GetY();
            $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
            $pdfAnamnese->Rect(40, $yIni, 95, $yFim - $yIni);
            $pdfAnamnese->Rect(135, $yIni, 25, $yFim - $yIni);
            $pdfAnamnese->Rect(160, $yIni, 40, $yFim - $yIni);


            $pdfAnamnese->SetWidths(array(30, 45, 30, 85));

            $sql = 'SELECT * FROM schema_campo WHERE nomCampo LIKE "%numTelefone%"';
            $arrCampoTel = $this->query($sql);
            $strTelefone = '';
            foreach($arrCampoTel as $arrCampo){
                $strTelefone .= $arrPaciente[$arrCampo['nomCampo']].' ';
            }

            if(isset($arrPaciente['datNascimento'])){

                $yIni = $pdfAnamnese->GetY();
                $datNascimento = $this->transformacaoData($arrPaciente['datNascimento']);
                $pdfAnamnese->PutRow(array('Data de Nasc.', $datNascimento, 'Telefone(s)', $strTelefone), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 45, $yFim - $yIni);
                $pdfAnamnese->Rect(85, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(115, $yIni, 85, $yFim - $yIni);

            }

            $pdfAnamnese->SetWidths(array(30, 140));
            foreach($arrCampos as $arrCampoAnamnese){

                $arrCampo = $modCampo->getCampo($arrCampoAnamnese['cdnCampo']);
                if($arrCampo['indTipo'] == 'date')
                    $arrPaciente[$arrCampo['nomCampo']] = $this->transformacaoData($arrPaciente[$arrCampo['nomCampo']]);

                if($arrCampo['nomCampo'] == 'codUf')
                    $arrPaciente['codUf'] = $this->transformacaoUf($arrPaciente['codUf']);


                $yIni = $pdfAnamnese->GetY();
                $pdfAnamnese->PutRow(array($arrCampo['desLabel'], $arrPaciente[$arrCampo['nomCampo']]), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 160, $yFim - $yIni);
            }

            $pdfAnamnese->SetWidths(array(30, 45, 30, 85));

            if($this->checaExiste('dependente', 'cdnPaciente', $cdnPaciente)){
                $strTipo = 'Dependente';
            }else{
                $strTipo = 'Titular';
            }

            if(is_null($arrPaciente['cdnParceria'])){
                $strParceria = 'Particular';
            }else{
                $arrParceria = $this->consultar('parceria', '*', array('cdnParceria' => $arrPaciente['cdnParceria']))[0];
                $strParceria = $arrParceria['nomParceria'];
            }
            

            $yIni = $pdfAnamnese->GetY();
            $pdfAnamnese->PutRow(array('Tipo do titular', $strTipo, 'Parceria do titular', $strParceria), true);
            $yFim = $pdfAnamnese->GetY();

            $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
            $pdfAnamnese->Rect(40, $yIni, 45, $yFim - $yIni);
            $pdfAnamnese->Rect(85, $yIni, 30, $yFim - $yIni);
            $pdfAnamnese->Rect(115, $yIni, 85, $yFim - $yIni);



            if($this->checaExiste('paciente_responsavel', 'cdnPaciente', $cdnPaciente)){
                $pdfAnamnese->Ln(1);
                $pdfAnamnese->SetAligns(array('C'));
                $pdfAnamnese->SetWidths(array(0));
                $pdfAnamnese->SetBorders(array(''));
                $pdfAnamnese->PutRow(array('RESPONSÁVEL LEGAL'), true);

                $pdfAnamnese->SetAligns(array('J', 'J'));
                $pdfAnamnese->SetWidths(array(30, 160));
                $pdfAnamnese->SetBorders(array('', ''));

                // $pdfAnamnese->Line($pdfAnamnese->GetX(), $pdfAnamnese->GetY(), $pdfAnamnese->w - 10, $pdfAnamnese->GetY());

                $arrResponsavel = $this->consultar('paciente_responsavel', '*', array('cdnPaciente' => $cdnPaciente))[0];

                $yIni = $pdfAnamnese->GetY();
                $pdfAnamnese->PutRow(array('Nome', $arrResponsavel['nomResponsavel']), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 160, $yFim - $yIni);

                $yIni = $pdfAnamnese->GetY();
                $pdfAnamnese->PutRow(array('Endereco', $arrResponsavel['strEndereco']), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 160, $yFim - $yIni);

                $yIni = $pdfAnamnese->GetY();
                $cepcidadeuf = '';
                if(trim($arrResponsavel['codCep']) != '')
                    $cepcidadeuf .= $arrResponsavel['codCep'].'/';
                if(trim($arrResponsavel['nomCidade']) != '')
                    $cepcidadeuf .= $arrResponsavel['nomCidade'].'/';
                if(trim($arrResponsavel['codUf']) != '')
                    $cepcidadeuf .= strtoupper($arrResponsavel['codUf']);
                $pdfAnamnese->PutRow(array('CEP/Cidade/UF', $cepcidadeuf), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 160, $yFim - $yIni);

                $yIni = $pdfAnamnese->GetY();
                $pdfAnamnese->PutRow(array('Telefone(s)', $arrResponsavel['numTelefones']), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 160, $yFim - $yIni);

                $yIni = $pdfAnamnese->GetY();
                $pdfAnamnese->PutRow(array('CPF', $arrResponsavel['codCpf']), true);
                $yFim = $pdfAnamnese->GetY();

                $pdfAnamnese->Rect(10, $yIni, 30, $yFim - $yIni);
                $pdfAnamnese->Rect(40, $yIni, 160, $yFim - $yIni);
            }

            $pdfAnamnese->Ln(1);
            $pdfAnamnese->SetAligns(array('C'));
            $pdfAnamnese->SetWidths(array(0));
            $pdfAnamnese->SetBorders(array(''));
            $pdfAnamnese->PutRow(array('QUESTIONÁRIO DE SAÚDE'), true);

            $pdfAnamnese->SetAligns(array('J', 'J'));
            $pdfAnamnese->SetWidths(array(150, 40));
            $pdfAnamnese->SetBorders(array('', ''));

            
            $arrPerguntas = $this->consultar('pergunta');
            $arrComOpcoes = array();
            $cont = 0;
            foreach($arrPerguntas as $arrPergunta){
                if(!$this->checaExiste('pergunta_opcao', 'cdnPergunta', $arrPergunta['cdnPergunta'])){
                    $cont++;

                    $arrCond = array('cdnPaciente' => $cdnPaciente,
                                     'conscond1' => 'AND',
                                     'cdnPergunta' => $arrPergunta['cdnPergunta']);
                    $arrResposta = $this->consultar('resposta', '*', $arrCond);
                    if(count($arrResposta) > 0){
                        $arrResposta = $arrResposta[0];
                        $strResposta = $arrResposta['strResposta'];
                    }else{
                        $strResposta = '';
                    }

                    $yIni = $pdfAnamnese->GetY();
                    $pdfAnamnese->PutRow(array($arrPergunta['strPergunta'], $strResposta), true);
                    $yFim = $pdfAnamnese->GetY();
                    
                    if($yFim < $yIni)
                        $yIni = $yFim - 11;

                    if($cont != count($arrPerguntas)){
                        $pdfAnamnese->Rect(10, $yIni, 95, 0);
                        $pdfAnamnese->Rect(105, $yIni, 95, 0);
                    }
                }else{
                    $arrComOpcoes[] = $arrPergunta;
                    
                }
            }

            $pdfAnamnese->SetWidths(array(40, 150));

            foreach($arrComOpcoes as $arrPergunta){
                $arrCond = array('cdnPaciente' => $cdnPaciente,
                                     'conscond1' => 'AND',
                                     'cdnPergunta' => $arrPergunta['cdnPergunta']);
                    $arrResposta = $this->consultar('resposta', '*', $arrCond);

                    $arrOpcoes = $this->consultar('pergunta_opcao', '*', array('cdnPergunta' => $arrPergunta['cdnPergunta']));

                    $strResposta = '';
                    foreach($arrOpcoes as $arrOpcao){
                        $arrCond = array('cdnPaciente' => $cdnPaciente,
                                         'conscond1' => 'AND',
                                         'cdnPergunta' => $arrPergunta['cdnPergunta'],
                                         'conscond2' => 'AND',
                                         'cdnOpcao' => $arrOpcao['cdnOpcao']);
                        $arrResposta = $this->consultar('resposta', '*', $arrCond);
                        if(count($arrResposta) > 0)
                            $strResposta .= '   ( X ) '.$arrOpcao['strOpcao'];
                        else
                            $strResposta .= '   (   ) '.$arrOpcao['strOpcao'];
                    }

                    $yIni = $pdfAnamnese->GetY();
                    $pdfAnamnese->PutRow(array($arrPergunta['strPergunta'], $strResposta), true);
                    $yFim = $pdfAnamnese->GetY();
                    
                    if($yFim < $yIni)
                        $yIni = $yFim - 11;
                    if($cont != count($arrPerguntas)){
                        $pdfAnamnese->Rect(10, $yIni, 95, 0);
                        $pdfAnamnese->Rect(105, $yIni, 95, 0);
                    }
            }

            $pdfAnamnese->Ln(5);
            $pdfAnamnese->SetAligns(array('C'));
            $pdfAnamnese->SetWidths(array(0));
            $pdfAnamnese->PutRow(array('Certifico que as informações prestadas são exatas.'), true);
            $pdfAnamnese->PutRow(array('Assinatura do Paciente'));
            $pdfAnamnese->Line(10, $pdfAnamnese->GetY(), $pdfAnamnese->w - 10, $pdfAnamnese->GetY());


            $pdfAnamnese->OutPut();
        }
    }