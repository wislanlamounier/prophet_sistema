<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o prontuário.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-30
     *
    **/
    class ModeloProntuario extends Modelo{
    	
    	/**
    	 * Método responsável por retornar o DTO de um tratamento
    	 *
    	 * @param Integer $cdnProntuarioTratamento - código numérico do tratamento
    	 *
    	**/
    	public function getProntuarioTratamento($cdnProntuarioTratamento){
    		return $this->getRegistro('prontuario_tratamento', 'cdnProntuarioTratamento', $cdnProntuarioTratamento);
    	}

        /**
         * Método responsável por retornar o DTO de um histórico
         *
         * @param Integer $cdnProntuarioHistorico - código numérico do histórico
         *
        **/
        public function getProntuarioHistorico($cdnProntuarioHistorico){
            return $this->getRegistro('prontuario_historico', 'cdnProntuarioHistorico', $cdnProntuarioHistorico);
        }

        /**
         * Método responsável por retornar o DTO de um anexo
         *
         * @param Integer $cdnProntuarioAnexo - código numérico do anexo
         *
        **/
        public function getProntuarioAnexo($cdnProntuarioAnexo){
            return $this->getRegistro('prontuario_anexo', 'cdnProntuarioAnexo', $cdnProntuarioAnexo);
        }

        /**
         * Método utilizado para atualizar as informações do tratamento
         *
         * @param Object $dtoProntuarioTratamento - objeto DTO do tratamento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function prontuarioTratamentoAtualizarFim(DTOProntuario_tratamento $dtoProntuarioTratamento){

            $dados = $dtoProntuarioTratamento->getArrayBanco();
            return $this->atualizar('prontuario_tratamento', $dados, array('cdnProntuarioTratamento' => $dtoProntuarioTratamento->getCdnProntuarioTratamento()));

        }

        /**
         * Método utilizado para preencher o DTO do tratamento
         *
         * @param Boolean $cdnProntuarioTratamento - código numérico do tratamento (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function prontuarioTratamentoPreparaDTO($cdnProntuarioTratamento = 0){
            $mesErro = '';
        	if($cdnProntuarioTratamento == 0){
                // está cadastrando
        		$dtoProntuarioTratamento = new DTOProntuario_tratamento();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('prontuario_tratamento', 'cdnProntuarioTratamento', $cdnProntuarioTratamento))
                    return array(new DTOProntuario_tratamento(), 'Registro não existente.');
                $dtoProntuarioTratamento = $this->getProntuarioTratamento($cdnProntuarioTratamento);
        	}

            $arrValidacao = array(
                'datProntuarioTratamento' => 'Informe uma data válida.',
                'desProntuarioTratamento' => '',
                'numDente' => ''
            );

            if(!isset($_POST['cdnDentista'])){
                $mesErro .= 'Informe o dentista. <br>';
            }else{
                if(trim($_POST['cdnDentista']) == ''){
                    $mesErro .= 'Informe o dentista. <br>';
                }else{
                    if(!$this->checaExiste('dentista', 'cdnUsuario', $_POST['cdnDentista'])){
                        $mesErro .= 'Informe um dentista válido. <br>';
                    }else{
                        $dtoProntuarioTratamento->setCdnDentista($_POST['cdnDentista']);
                    }
                }
            }

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoProntuarioTratamento->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoProntuarioTratamento, $mesErro);
        }


        /**
         * Método utilizado para preencher o DTO do anexo
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function prontuarioAnexoPreparaDTO($cdnPaciente){
            $mesErro = '';
            $dtoProntuarioAnexo = new DTOProntuario_anexo();
            if(!$this->checaExiste('paciente', 'cdnPaciente', $cdnPaciente))
                return array($dtoProntuarioTratamento, 'Registro não existente.');
            $dtoProntuarioAnexo->setCdnPaciente($cdnPaciente);

            if(isset($_FILES['strDiretorio'])){
                $arquivo = new Arquivo('arquivos_clinicas/'.$_SESSION['cdnClinica'].'/prontuarios/'.$cdnPaciente, 'strDiretorio');
                $strDiretorio = $arquivo->finalizar();
                if(!$dtoProntuarioAnexo->setStrDiretorio($strDiretorio)){
                    $mesErro .= 'Informe um arquivo válido.<br>';
                    unlink($strDiretorio);
                }
                if(!$dtoProntuarioAnexo->setValTamanho($arquivo->tamanho())){
                    $mesErro .= 'O tamanho do arquivo é inválido.<br>';
                    unlink($strDiretorio);
                }
            }else{
                $mesErro .= 'Informe um arquivo.<br>';
            }

            if(isset($_POST['desProntuarioAnexo']))
                $dtoProntuarioAnexo->setDesProntuarioAnexo($_POST['desProntuarioAnexo']);

            return array($dtoProntuarioAnexo, $mesErro);
        }

        /**
         * Método utilizado para registrar o tratamento
         * no banco de dados
         *
         * @param Object $dtoProntuarioTratamento - objeto DTO do tratamento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function prontuarioTratamentoCadastrarFim(DTOProntuario_tratamento $dtoProntuarioTratamento){

                $dadosFinais = $dtoProntuarioTratamento->getArrayBanco();
                return $this->inserir('prontuario_tratamento', $dadosFinais);

        }

        /**
         * Método utilizado para registrar o anexo
         * no banco de dados
         *
         * @param Object $dtoProntuarioAnexo - objeto DTO do anexo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function prontuarioAnexoFim(DTOProntuario_anexo $dtoProntuarioAnexo){

                $dadosFinais = $dtoProntuarioAnexo->getArrayBanco();
                return $this->inserir('prontuario_anexo', $dadosFinais);

        }


        /**
         * Método responsável pela impressão do prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void
         *
        **/
        public function prontuarioImprimirFim($cdnPaciente){
            $pdfProntuario = new PDFProntuario('P', 'mm');
            $modPaciente = new ModeloPaciente();
            $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
            $pdfProntuario->setArrPaciente($arrPaciente);

            $pdfProntuario->AddPage();
            $pdfProntuario->AliasNbPages();

            $pdfProntuario->SetBorders(array('', '', ''));
            $pdfProntuario->SetFont('Arial', '', 10);


            $datIntervalo = $_POST['datIntervalo'];

            $datIntervalo = explode('-', $datIntervalo);

            $datInicio = trim($datIntervalo[0]);
            $datInicio = explode('/', $datInicio);
            $datInicio = $datInicio[2].'-'.$datInicio[1].'-'.$datInicio[0];

            $datFim = trim($datIntervalo[1]);
            $datFim = explode('/', $datFim);
            $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];

            $arrTratamentos = $this->consultar('prontuario_tratamento', '*', array('cdnPaciente' => $cdnPaciente), 'datProntuarioTratamento, cdnDentista');
            $arrDatas = array();
            $arrDentista = array();

            foreach($arrTratamentos as $arrTratamento){
                $dtoProntuarioTratamento = $this->getProntuarioTratamento($arrTratamento['cdnProntuarioTratamento']);
                $datTratamento = $dtoProntuarioTratamento->getDatProntuarioTratamento(true);
                $cdnDentista = $dtoProntuarioTratamento->getCdnDentista();

                if(!isset($arrDatas[$datTratamento]))
                    $arrDatas[$datTratamento] = array();

                if(!isset($arrDatas[$datTratamento][$cdnDentista]))
                    $arrDatas[$datTratamento][$cdnDentista] = array();

                $arrDatas[$datTratamento][$cdnDentista][] = serialize($dtoProntuarioTratamento);
            }

            $modMain = new ModeloMain(true);
            $pdfProntuario->Ln(5);
            foreach($arrDatas as $datTratamento => $arrDentistas){
                $yIni = $pdfProntuario->GetY();
                $pdfProntuario->SetAligns(array('J'));
                $pdfProntuario->SetBorders(array());
                $pdfProntuario->SetWidths(array('0'));
                $pdfProntuario->PutRow(array('Data: '.$datTratamento), true);
                foreach($arrDentistas as $cdnDentista=>$arrTratamentos){
                    foreach($arrTratamentos as $arrTratamento){
                        $dtoProntuarioTratamento = unserialize($arrTratamento);
                        $arrUsuario = $modMain->getUsuario($dtoProntuarioTratamento->getCdnDentista());
                        $pdfProntuario->SetWidths(array(5, 20, 100, 65));
                        $pdfProntuario->SetAligns(array('C', 'C', 'J', 'J'));
                        $pdfProntuario->PutRow(array('',
                                                     $dtoProntuarioTratamento->getNumDente(),
                                                     $dtoProntuarioTratamento->getDesProntuarioTratamento(),
                                                     $arrUsuario['nomUsuario']), true);
                    }
                }
                $arrNomes = array('');
                $pdfProntuario->SetWidths(array(2, 43, 2.5, 45, 2.5, 45, 2.5, 45, 2.5));
                $pdfProntuario->SetBorders(array('', 'B', '', 'B', '', 'B', '', 'B', ''));
                $pdfProntuario->SetAligns(array('', 'C', 'C', 'C', 'C', 'C', 'C'));
                for($i = 0; $i < count($arrDentistas); $i++){
                    $cdnDentista = array_keys($arrDentistas)[$i];
                    $arrUsuario = $modMain->getUsuario($cdnDentista);
                    $arrNomes[] = $arrUsuario['nomUsuario'];
                    $arrNomes[] = '';
                    if(($i % 4 == 0 and $i != 0) or $i == count($arrDentistas) - 1){
                        $pdfProntuario->PutRow($arrNomes);
                    }
                }
                $yFim = $pdfProntuario->GetY();

                $pdfProntuario->Rect(10, $yIni, $pdfProntuario->w - 20, $yFim - $yIni);

                $pdfProntuario->Ln(5);
            }


            if(strtotime($datInicio) < strtotime($datFim)){
                $dtoHistorico = new DTOProntuario_historico();
                $dtoHistorico->setCdnPaciente($cdnPaciente);
                $dtoHistorico->setDatInicio($datInicio);
                $dtoHistorico->setDatFim($datFim);
                $arrDados = $dtoHistorico->getArrayBanco();
                $this->inserir('prontuario_historico', $arrDados);
            }

            $pdfProntuario->OutPut();


        }

        /**
         * Método responsável por verificar se há algum prontuário impresso nesta data
         *
         * @param String $datInicio - data de inicio
         * @param String $datFim - data final
         *
        **/
        public function prontuarioVerificaDatas($datInicio, $datFim, $cdnPaciente){
            $sql = 'SELECT * FROM prontuario_historico WHERE ((datInicio <= "'.$datFim.'"    AND datFim >= "'.$datFim.'") OR 
                                                             (datInicio <= "'.$datInicio.'" AND datFim <= "'.$datFim.'") OR 
                                                             (datInicio >= "'.$datInicio.'" AND datFim >= "'.$datFim.'") OR 
                                                             (datInicio >= "'.$datInicio.'" AND datFim <= "'.$datFim.'") OR
                                                             (datFim    <= "'.$datInicio.'" AND datFim >= "'.$datFim.'") OR
                                                             (datFim    <= "'.$datInicio.'" AND datFim <= "'.$datFim.'")) AND
                                                             cdnPaciente = '.$cdnPaciente;
                                                             echo $sql;
            $arrHistoricos = $this->query($sql);
            if(count($arrHistoricos) > 0){
                echo '<b>Prontuário já impresso nas seguintes datas:</b>';
                echo '<ul>';
                foreach($arrHistoricos as $arrHistorico){
                    $dtoHistorico = $this->getProntuarioHistorico($arrHistorico['cdnProntuarioHistorico']);
                    echo '<li>'.$dtoHistorico->getDatInicio(true).' - '.$dtoHistorico->getDatFim(true).'</li>';
                }
                echo '</ul>';
            }else{
                echo 1;
            }

        }

        /**
         * Método responsável por realizar a verificação da necessidade de impressão de prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         *
        **/
        public function prontuarioAviso($cdnPaciente){
            $arrHistoricos = $this->consultar('prontuario_historico', '*', array('cdnPaciente' => $cdnPaciente), 'datFim');

            $ultimaImpressao = ' Nenhuma impressão foi realizada até hoje.';
            $sql = 'SELECT COUNT(cdnConsulta) as "qtd" FROM consulta WHERE cdnPaciente = '.$cdnPaciente.' AND indFinalizada = 1';
            if(count($arrHistoricos) > 0){
                $arrHistorico = $arrHistoricos[count($arrHistoricos) - 1];
                $dtoHistorico = $this->getProntuarioHistorico($arrHistorico['cdnProntuarioHistorico']);
                $datUltimo = $dtoHistorico->getDatFim();
                $sql .= ' AND datConsulta > "'.$datUltimo.'"';
                $ultimaImpressao = ' A última impressão foi realizada do dia '.$dtoHistorico->getDatInicio(true).'
                                     até o dia '.$dtoHistorico->getDatFim(true).'.';
            }


            $arrConsulta = $this->query($sql)[0];

            $link = '<a href="'.BASE_URL.'/prontuario/imprimir/'.$cdnPaciente.'" target="_blank">realizar a impressão</a>';

            if($arrConsulta['qtd'] >= 4){
                echo 'Recomenda-se '.$link.' do prontuário deste paciente.'.$ultimaImpressao;
            }
        }
    }