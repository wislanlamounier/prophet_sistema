<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o cronometro.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-14
     *
    **/
    class ModeloCronometro extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do cronometro requisitado
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Object - objeto DTO do cronometro
         *
        **/
        public function getCronometro($cdnCronometro){
            return $this->getRegistro('cronometro', 'cdnCronometro', $cdnCronometro);
        }

        /**
         * Método utilizado para atualizar as informações do cronometro
         *
         * @param Object $dtoCronometro - objeto DTO do cronometro
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function cronometroAtualizarFim(DTOCronometro $dtoCronometro){

            $dados = $dtoCronometro->getArrayBanco();
            return $this->atualizar('cronometro', $dados, array('cdnCronometro' => $dtoCronometro->getCdnCronometro()));

        }

        /**
         * Método utilizado para preencher o DTO do cronometro para cadastro.
         *
         * @param Boolean $cdnCronometro - código numérico do cronometro (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function cronometroPreparaDTO($cdnCronometro = 0){
            $mesErro = '';
        	if($cdnCronometro == 0){
                // está cadastrando
        		$dtoCronometro = new DTOCronometro();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro))
                    return array(new DTOCronometro(), 'Registro não existente.');
                $dtoCronometro = $this->getCronometro($cdnCronometro);
        	}

            $arrValidacao = array(
                'nomCronometro' => array('Informe o nome do cronometro.'),
                'numTelefone1' => '',
                'numTelefone2' => '',
                'numWhatsapp' => '',
                'nomFacebook' => '',
                'nomRepresentante' => '',
                'numRepresentanteTelefone' => '',
                'strRepresentanteEmail' => 'Informe um e-mail válido.',
                'desCronometro' => ''
            );

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
            	if(!$dtoCronometro->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoCronometro, $mesErro);
        }

        /**
         * Método utilizado para registrar o cronometro
         * no banco de dados
         *
         * @param Object $dtoCronometro - objeto DTO do cronometro
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function cronometroCadastrarFim(DTOCronometro $dtoCronometro){

                $dadosFinais = $dtoCronometro->getArrayBanco();
                return $this->inserir('cronometro', $dadosFinais);

        }

        /**
         * Método responsável por preparar o DTO do cronometro de chegada
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Array - DTO[0] e erros[1]
         *
        **/
        public function cronometroChegadaDTO($cdnConsulta){
            $mesErro = '';
            if(!isset($_POST['cdnPaciente'])){
                $mesErro = 'Informe o paciente.';
            }else{
                if(!$this->checaExiste('paciente', 'cdnPaciente', $_POST['cdnPaciente'])){
                    $mesErro = 'Informe um paciente válido.';
                }
            }

            if($mesErro == ''){
                $sql = 'SELECT * FROM cronometro WHERE
                        ISNULL(horaEntrada) AND ISNULL(horaSaida) AND cdnPaciente = '.$_POST['cdnPaciente'];
                $arrSalaEspera = $this->query($sql);

                $sql = 'SELECT * FROM cronometro WHERE
                        !ISNULL(horaEntrada) AND ISNULL(horaSaida) AND cdnPaciente = '.$_POST['cdnPaciente'];
                $arrConsultorio = $this->query($sql);

                if(count($arrConsultorio) > 0 or count($arrSalaEspera) > 0)
                    return array(new DTOCronometro(), 'Paciente já registrado.');

                $dtoCronometro = new DTOCronometro();
                $dtoCronometro->setCdnPaciente($_POST['cdnPaciente']);
                $dtoCronometro->setHoraChegada(date('Y-m-d H:i:s'));
                $dtoCronometro->setDatCronometro(date('Y-m-d'));
                if($cdnConsulta != 0){
                    if($this->checaExiste('consulta', 'cdnConsulta', $cdnConsulta))
                        $dtoCronometro->setCdnConsulta($cdnConsulta);
                }

                return array($dtoCronometro, $mesErro);
            }
            return array(new DTOCronometro(), $mesErro);
        }

        /**
         * Método responsável por retornar o DTO de entrada
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Object - DTO do cronometro
         *
        **/
        public function cronometroEntradaDTO($cdnCronometro){
            $mesErro = '';
            $dtoCronometro = $this->getCronometro($cdnCronometro);

            $dtoCronometro->setHoraEntrada(date('Y-m-d H:i:s'));

            return $dtoCronometro;
        }

        /**
         * Método responsável por retornar o DTO de entrada
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Object - DTO do cronometro
         *
        **/
        public function cronometroSaidaDTO($cdnCronometro){
            $mesErro = '';
            $dtoCronometro = $this->getCronometro($cdnCronometro);

            $dtoCronometro->setHoraSaida(date('Y-m-d H:i:s'));

            $cdnConsulta = $dtoCronometro->getCdnConsulta();
            if(!is_null($cdnConsulta)){
                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($dtoCronometro->getCdnConsulta());
                $dtoConsulta->setHoraFinalizada(date('H:i').':00');
                $modConsulta->consultaRemarcarFim($dtoConsulta);
            }

            return $dtoCronometro;
        }

        /**
         * Método responsável por voltar o paciente para a sala de espera
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroVoltarFim($cdnCronometro){
            $dtoCronometro = $this->getCronometro($cdnCronometro);

            $dtoCronometro->setHoraEntrada(null);

            $arrDados = $dtoCronometro->getArrayBanco();

            return $this->atualizar('cronometro', $arrDados, array('cdnCronometro' => $cdnCronometro));
        }
    }
