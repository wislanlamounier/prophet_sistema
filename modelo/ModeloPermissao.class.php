<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo as permissões.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-18
     *
    **/
    class ModeloPermissao extends Modelo{

    	/**
    	 * Método responsável por retornar o DTO de uma permissão
    	 *
    	 * @param Integer $cdnUsuario - código numérico da permissão
    	 *
    	**/
    	public function getPermissao($cdnUsuario){
    		return $this->getRegistro('usuario_permissao', 'cdnUsuario', $cdnUsuario);
    	}

    	/**
    	 * Método responsável por retornar o array dos pacotes de permissões pertencidos
    	 * a este usuário
    	 *
    	 * @param Integer $cdnUsuario - código numérico do usuário
    	 *
    	**/
    	public function permissaoArray($cdnUsuario){
    		$dtoPermissao = $this->getPermissao($cdnUsuario);

    		$strPermissoes = $dtoPermissao->getStrPermissao();
    		$strPermissoes = explode('|', $strPermissoes);

    		$possui = array();

    		include('inc/funcoes.inc.php');
    		$bool = true;
    		foreach($pacotes as $controle => $acoes){
                $possui[$controle] = array();
    			foreach($acoes as $acao => $funcoes){
    				$bool = true;
    				foreach($funcoes as $funcao){
    					if(!in_array($funcao, $strPermissoes))
    						$bool = false;
    				}
    				if($bool)
    					$possui[$controle][] = $acao;
    			}
    		}

    		return $possui;
    	}

        /** 
         * Método responsável por finalizar a atualização da permissão
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function permissaoAtualizarFim($cdnUsuario){
            include('inc/funcoes.inc.php');
            $strPermissao = array();
            foreach($_POST as $controle => $acoes){
                foreach($acoes as $acao){
                    foreach($pacotes[$controle][$acao] as $funcao){
                        if(!in_array($funcao, $strPermissao))
                            $strPermissao[] = $funcao;
                    }
                }
            }
            $strPermissao = implode('|', $strPermissao);
            $dtoPermissao = new DTOUsuario_permissao();
            $dtoPermissao->setCdnUsuario($cdnUsuario);
            $dtoPermissao->setStrPermissao($strPermissao);
            $arrDados = $dtoPermissao->getArrayBanco();
            if($this->checaExiste('usuario_permissao', 'cdnUsuario', $cdnUsuario))
                return $this->atualizar('usuario_permissao', $arrDados, array('cdnUsuario' => $cdnUsuario));
            else
                return $this->inserir('usuario_permissao', $arrDados);
        }

    }