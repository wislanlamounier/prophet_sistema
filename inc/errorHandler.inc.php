<?php

	/**
	 * Função responsável por lidar com os erros do programa
	 *
	 * @param String $errno - tipo do erro
	 * @param String $errstr - mensagem de erro
	 * @param String $errfile - arquivo do erro
	 * @param String $errline - linha do arquivo
	 *
	**/
	function errorHandler($errno, $errstr, $errfile, $errline){
		if(!strpos($errstr, 'deprecated') > 0){
			$modelo = new Modelo();
			$dados = array(
				'strErro' => $errstr,
				'nomArquivo' => $errfile,
				'numLinha' => $errline,
				'datErro' => date('Y-m-d H:i:s')
				);
			$modelo->inserir('erro', $dados);
			$_SESSION['erroPHP'] = 'Ops! Um erro ocorreu. Por favor, contate a administração do sistema. <br>
									Data/Hora do erro: '.date('d/m/Y H:i:s');
		}

	}

	/**
	 * Função responsável por lidar com erros fatais do PHP
	 *
	**/
	function fatalErrorHandler(){
		$ultimoErro = error_get_last();
		if ($ultimoErro['type'] === E_ERROR) {
			errorHandler(E_ERROR, $ultimoErro['message'], $ultimoErro['file'], $ultimoErro['line']);
			$controle = new Controlador();
			$controle->inicio();
		}
	}

	if($_SERVER['HTTP_HOST'] != 'localhost:8083'){
		set_error_handler("errorHandler");
		register_shutdown_function('fatalErrorHandler');
	}
