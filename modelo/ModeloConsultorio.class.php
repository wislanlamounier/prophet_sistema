<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o consultório.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-15
     *
    **/
    class ModeloConsultorio extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do consultório requisitado
         *
         * @param Integer $cdnConsultorio - código numérico do consultório
         * @return Object - objeto DTO do consultório
         *
        **/
        public function getConsultorio($cdnConsultorio){
            return $this->getRegistro('consultorio', 'cdnConsultorio', $cdnConsultorio);
        }

        /**
         * Método utilizado para atualizar as informações do consultório
         *
         * @param Object $dtoConsultorio - objeto DTO do consultório
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function consultorioAtualizarFim(DTOConsultorio $dtoConsultorio){

            $dados = $dtoConsultorio->getArrayBanco();
            return $this->atualizar('consultorio', $dados, array('cdnConsultorio' => $dtoConsultorio->getCdnConsultorio()));

        }

        /**
         * Método utilizado para preencher o DTO do consultório para cadastro.
         *
         * @param Boolean $cdnConsultorio - código numérico do consultório (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function consultorioPreparaDTO($cdnConsultorio = 0){
            $mesErro = '';
        	if($cdnConsultorio == 0){
                // está cadastrando
        		$dtoConsultorio = new DTOConsultorio();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio))
                    return array(new DTOConsultorio(), 'Registro não existente.');
                $dtoConsultorio = $this->getConsultorio($cdnConsultorio);
        	}

            $arrValidacao = array(
                'numConsultorio' => array('Informe o número do consultório.')
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
            	if(!$dtoConsultorio->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoConsultorio, $mesErro);
        }

        /**
         * Método utilizado para registrar o consultório
         * no banco de dados
         *
         * @param Object $dtoConsultorio - objeto DTO do consultório
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function consultorioCadastrarFim(DTOConsultorio $dtoConsultorio){

                $dadosFinais = $dtoConsultorio->getArrayBanco();
                return $this->inserir('consultorio', $dadosFinais);

        }

        /**
         * Método responsável por retornar um select de consultório.
         *
         * @param Integer $cdnConsultorio - código numérico do consultório para selecionar de início (opcional)
         * @param Boolean $label - colocar a label ou não. Padrão: true.
         * @param String $classe - classe do input. Padrão: iptCdnConsultorio.
         * @param String $nome - nome do input. Padrão: cdnConsultorio.
         * @return String - select de clientes
         *
        **/
        public function consultorioRetornaSelect($cdnConsultorio = 0, $label = true, $classe = 'iptCdnConsultorio', $nome = 'cdnConsultorio'){
            $arrAreasAtuacoes = $this->consultar('consultorio', '*', array('indDesvinculado' => 0), 'nomConsultorio');
            $select = '';
            if($label){
                $select .='<div class="form-group">
                               <label class="control-label" for="'.$nome.'">Consultório</label>';
            }
            $select .= '
                <select name="'.$nome.'" class="form-control '.$classe.'">
                <option id="optPadrao" value="">Selecione o consultório</option>'.PHP_EOL;
            foreach($arrAreasAtuacoes as $arrConsultorio){
                $dtoConsultorio = $this->getConsultorio($arrConsultorio['cdnConsultorio']);
                if($dtoConsultorio->getCdnConsultorio() == $cdnConsultorio)
                    $selected = 'selected';
                else
                    $selected = '';

                $select .= '<option '.$selected.' value="'.$dtoConsultorio->getCdnConsultorio().'">'.$dtoConsultorio->getCodConsultorio().'</option>';
            }
            $select .= '</select>';
            if($label)
                $select .= '</div>';

            return $select;
        }
    }
