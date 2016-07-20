<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o campo
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-28
     *
    **/
    class ModeloCampo extends Modelo{
    	use Validacao;
    	use Transformacao;

    	/** 
    	 * Método responsável por retornar a lista dos campos existentes
    	 * na tabela selecionada
    	 *
         * @param String $nomTabela - nome da tabela.
    	 * @param Boolean $indMostrar - booleano que indica se deve mostrar os campos que devem
    	 *								aparecer na tela ou todos os campos.
    	 * @return Array - array dos campos
    	 *
    	**/
    	public function getCampos($nomTabela, $indMostrar){
            $arrCond = array('nomTabela' => $nomTabela,
                             'conscond1' => 'AND',
                             'cdnPai'    => 0);

    		if($indMostrar){
    			$arrCond['conscond2'] = 'AND';
    			$arrCond['indMostrar'] = 1;
    		}

    		$arrCampos = $this->consultar('schema_campo', '*', $arrCond, 'codSequencial');
			return $arrCampos;
    	}

    	/** 
    	 * Método responsável por pegar os campos filhos de um pai
    	 * 
    	 * @param Integer $cdnCampo - código numérico do campo (opcional)
    	 * @return Array - array dos campos
    	 *
    	**/
    	public function getFilhos($cdnCampo = 0){
            if($cdnCampo != 0){
    			$arrCond = array('cdnPai' => $cdnCampo);
        		$arrCampos = $this->consultar('schema_campo', '*', $arrCond, 'codSequencial');
    			return $arrCampos;
            }else{
                $sql = 'SELECT * FROM schema_campo WHERE cdnPai != 0 ORDER BY cdnPai, codSequencial';
                $arrPais = array();
                $arrCampos = $this->query($sql);

                foreach($arrCampos as $arrCampo){
                    if(!array_key_exists($arrCampo['cdnPai'], $arrPais))
                        $arrPais[$arrCampo['cdnPai']] = array();

                    $arrPais[$arrCampo['cdnPai']][] = array($arrCampo['cdnCampo'], $arrCampo['codSequencial'], $arrCampo['desLabel']);

                }

                return $arrPais;
            }
    	}

    	/**
    	 * Método responsável por retornar o campo desejado
    	 *
    	 * @param Integer $cdnCampo - código numérico do campo
    	 * @return Array - array do campo
    	 *
    	**/
    	public function getCampo($cdnCampo){
    		$arrCond = array('cdnCampo' => $cdnCampo);
    		return $this->consultar('schema_campo', '*', $arrCond)[0];
    	}

        /**
         * Método responsável por atualizar a sequência de um campo
         *
         * @param Integer $cdnCampo - código numérico de um número
         * @param Integer $codSequencial - sequencia do campo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function campoOrdenacaoFim($cdnCampo, $codSequencial){
            $arrCampo = $this->getCampo($cdnCampo);
            $arrCampo['codSequencial'] = $codSequencial;
            return $this->atualizar('schema_campo', $arrCampo, array('cdnCampo' => $cdnCampo));
        }

        /**
         * Método responsável por retornar as classes necessárias ao input
         * 
         * @param String $type - tipo do input
         *
        **/
        public function getClasses($type){
            $classes = '';
            switch ($type) {
                case 'cpf':
                    $classes .= ' mask-cpf ';
                    break;
                
                case 'cnpj':
                    $classes .= ' mask-cnpj ';
                    break;

                case 'cpfcnpj':
                    $classes .= ' mask-cpfcnpj ';
                    break;

                case 'date':
                    $classes .= ' mask-date ';
                    break;

                case 'cep':
                    $classes .= ' mask-cep ';
                    break;

                case 'moeda':
                    $classes .= ' mask-money ';
                    break;

                case 'hora':
                    $classes .= ' mask-time ';
                    break;

                case 'datetime':
                    $classes .= ' mask-datetime ';
                    break;

                default:
                    break;
            }
            return $classes;
        }

        /**
         * Método responsável por detectar se é utilizado sobrenome
         *
         * @return Boolean - true se utiliza, false se não
         *
        **/
        public function campoUtilizaSobrenome(){

            $arrCond = array('nomCampo' => 'nomSobrenome');
            $arrCampos = $this->consultar('schema_campo', '*', $arrCond);
            return count($arrCampos) > 0;
        }

    }