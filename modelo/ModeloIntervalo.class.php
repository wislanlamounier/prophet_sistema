<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o intervalo.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-02-01
     *
    **/
    class ModeloIntervalo extends Modelo{

        public function getIntervalo($cdnIntervalo){
            return $this->getRegistro('dentista_intervalo', 'cdnIntervalo', $cdnIntervalo);
        }


		public function intervaloPreparaDTO($cdnIntervalo = 0){
            $mesErro = '';
            if($cdnIntervalo == 0){
                // está cadastrando
                $dtoIntervalo = new DTODentista_intervalo();
            }else{
                // está atualizando
                if(!$this->checaExiste('dentista_intervalo', 'cdnIntervalo', $cdnIntervalo))
                    return array(new DTODentista_intervalo(), 'Registro não existente.');
                $dtoIntervalo = $this->getIntervalo($cdnIntervalo);
            }

            $arrValidacao = array(
                'horaInicio' => array('Informe um horário de inicio.'),
                'horaFinal' => array('Informe um horário de término.'),
            );

            $dtoIntervalo->setIndPermanente(isset($_POST['indPermanente']));

            $semana = array('Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado');

            foreach($semana as $dia){
            	$nomFuncao = 'setInd'.$dia;
            	$dtoIntervalo->{$nomFuncao}(isset($_POST['ind'.$dia]));
            }

            if($dtoIntervalo->getIndPermanente()){
				foreach($semana as $dia){
	            	$nomFuncao = 'setInd'.$dia;
	            	$dtoIntervalo->{$nomFuncao}(1);
            	}
            }else{
				foreach($semana as $dia){
	            	$nomFuncao = 'setInd'.$dia;
	            	$dtoIntervalo->{$nomFuncao}(isset($_POST['ind'.$dia]));
            	}
            }

            $especifico = true;
            foreach($semana as $dia){
            	$nomFuncao = 'getInd'.$dia;
            	if($dtoIntervalo->{$nomFuncao}())
            		$especifico = false;
            }
            if($especifico){
            	$arrValidacao['datIntervalo'] = array('Informe uma data válida.');
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
                if(!$dtoIntervalo->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            if(strtotime($dtoIntervalo->getHoraInicio().':00') >= strtotime($dtoIntervalo->getHoraFinal().':00')){
            	$mesErro .= 'O horário de término deve ser superior ao horário de início.';
            }

            return array($dtoIntervalo, $mesErro);
        }

        public function intervaloCadastrarFim(DTODentista_intervalo $dtoIntervalo){

            $dadosFinais = $dtoIntervalo->getArrayBanco();
            return $this->inserir('dentista_intervalo', $dadosFinais);

        }

        public function intervaloAtualizarFim(DTODentista_intervalo $dtoIntervalo){

            $dados = $dtoIntervalo->getArrayBanco();
            return $this->atualizar('dentista_intervalo', $dados, array('cdnIntervalo' => $dtoIntervalo->getCdnIntervalo()));

        }

        public function intervaloDeletarFim($cdnIntervalo){
            return $this->deletar('dentista_intervalo', array('cdnIntervalo' => $cdnIntervalo));
        }
    }