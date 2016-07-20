<?php

	/**
	 * Arquivo de configuração da conexão com o banco de dados
	 *
	**/
	// if($_SERVER['HTTP_HOST'] == 'localhost:8083'){
	// 	define('HOST', 'localhost');
	// 	define('USUARIO_BANCO', 'root');
	// 	define('SENHA_BANCO', 'rafael');
	// 	define('BASE_URL', 'http://localhost:8083');
	// 	if(!isset($_SESSION['nomBanco'])){
	// 	    define('BANCO', 'prophet_main');
	// 	}else{
	// 	    define('BANCO', 'prophet_'.$_SESSION['nomBanco']);
	// 	}
	// }else{
	// 	define('HOST', 'localhost');
	// 	define('USUARIO_BANCO', 'root');
	// 	define('SENHA_BANCO', 'bentonet2412');
	// 	define('BASE_URL', 'http://93.188.167.166');
	// 	if(!isset($_SESSION['nomBanco'])){
	// 		define('BANCO', 'prophet_main');
	// 	}else{
	// 		define('BANCO', 'prophet_'.$_SESSION['nomBanco']);
	// 	}
	// }
	switch ($_SERVER['HTTP_HOST']) {
		case 'localhost:8083':
			define('HOST', 'localhost');
			define('USUARIO_BANCO', 'root');
			define('SENHA_BANCO', '');
			define('BASE_URL', 'http://localhost:8083');
			if(!isset($_SESSION['nomBanco'])){
			    define('BANCO', 'prophet_main');
			}else{
			    define('BANCO', 'prophet_'.$_SESSION['nomBanco']);
			}
			define('LOCAL', 'localhost');
			break;
		
		default:
			define('HOST', 'localhost');
			define('USUARIO_BANCO', 'root');
			define('SENHA_BANCO', 'bentonet2412');
			define('BASE_URL', 'http://prophet.com.br');
			if(!isset($_SESSION['nomBanco'])){
				define('BANCO', 'prophet_main');
			}else{
				define('BANCO', 'prophet_'.$_SESSION['nomBanco']);
			}
			define('LOCAL', 'web');
			break;
	}