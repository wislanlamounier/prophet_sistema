<?php
trait DTO{

    public function getArrayDados(){
        $dados = array();
        foreach($this as $atributo => $valor){
            $dados[$atributo] = $valor;
        }
        return $dados;
    }
    
    
    public function getArrayBanco($campos = array()){
        $dados = array();
        foreach($this->getArrayDados() as $dado=>$valor){
            if(!in_array($dado, $campos)){
            	if($dado != 'desSenha')
                	$dados[$dado] = $valor;
                else
                	if(trim($valor) != '')
                		$dados[$dado] = $valor;
            }
        }
        return $dados;
    }
}