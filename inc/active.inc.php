<?php

    /**
     * Arquivo responsável por descobrir em qual link colocar a classe "active" no menu
     *
    **/

    $comp = strrchr($_SERVER['REQUEST_URI'], '?');
	$end = str_replace($comp, '', $_SERVER['REQUEST_URI']);
	$url = explode('/', $end);
	array_shift($url);
	if(trim($url[0]) == '')
		unset($url[0]);
	if(isset($url[0]))
		$moduloAtual = $url[0];
    else
        $moduloAtual = 'inicio';

    if(isset($url[1]))
		$acaoAtual = $url[1];
    else
        $acaoAtual = 'consultar';

    $modulosPai = array('clinica'  => '',
                        'inicio'   => '',
                        'paciente' => '');

    $listaFilhos = array('clinica' => array('fornecedor',
                                            'areaAtuacao',
                                            'consultorio',
                                            'dentista',
                                            'colaborador',
                                            'usuario',
                                            'clinica',
                                            'clinicaRadiologica'),
                         'paciente' => array('empresa', 'paciente'));

    $modulosFilhos = array('fornecedor'  => '',
                           'areaAtuacao' => '',
                           'consultorio' => '',
                           'dentista'    => '',
                           'colaborador' => '',
                           'usuario'     => '',
                           'clinica'     => '',
                           'empresa'     => '',
                           'clinicaRadiologica' => '',
                           'paciente' => '',
                           'parceria');

    foreach($modulosFilhos as $modulo=>$val){
        if($acaoAtual != 'inicio'){
            if($modulo == $moduloAtual)
                $modulosFilhos[$modulo] = 'active';
        }
    }

    foreach($modulosPai as $modulo=>$val){
        if($acaoAtual != 'inicio'){
            if(isset($listaFilhos[$modulo])){
                if(in_array($moduloAtual, $listaFilhos[$modulo])){
                    $modulosPai[$modulo] = 'active';
                }
            }
        }else{
            $modulosPai['inicio'] = 'active';
        }
    }
