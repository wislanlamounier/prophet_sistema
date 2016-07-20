<?php

	/**
	 * Função responsável por carregar os arquivos automaticamente
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @param String $classe - nome da classe que está sendo chamada
	 *
	**/
    function autoload($classe){
    	if(file_exists('controlador/'.$classe.'.class.php')){
    		include_once('controlador/'.$classe.'.class.php');
    	}
        if(file_exists('modelo/'.$classe.'.class.php')){
    		include_once('modelo/'.$classe.'.class.php');
    	}
        if(file_exists('modelo/DTO/'.$classe.'.class.php')){
    		include_once('modelo/DTO/'.$classe.'.class.php');
    	}
        if(file_exists('modelo/DTO/Relacoes/'.$classe.'.class.php')){
            include_once('modelo/DTO/Relacoes/'.$classe.'.class.php');
        }
		if(file_exists('modelo/DTO/'.$classe.'.trait.php')){
        	require_once('modelo/DTO/'.$classe.'.trait.php');
		}
		if(file_exists('modelo/PDF/'.$classe.'.trait.php')){
			require_once('modelo/PDF/'.$classe.'.trait.php');
		}
        if(file_exists('modelo/PDF/'.$classe.'.class.php')){
    		include_once('modelo/PDF/'.$classe.'.class.php');
    	}
    	if(file_exists('modelo/trait/'.$classe.'.trait.php')){
    		include_once('modelo/trait/'.$classe.'.trait.php');
    	}
        if(file_exists('modelo/Importacao/'.$classe.'.class.php')){
            include_once('modelo/Importacao/'.$classe.'.class.php');
        }
		if(file_exists('visualizador/_classes/'.$classe.'.class.php')){
        	require_once('visualizador/_classes/'.$classe.'.class.php');
		}
		if(file_exists('plugins/fpdf/'.strtolower($classe).'.php')){
	        require_once('plugins/fpdf/'.strtolower($classe).'.php');
		}
		if(file_exists('plugins/PHPMailer/class.'.strtolower($classe).'.php')){
            require_once('plugins/PHPMailer/class.phpmailer.php');
	        require_once('plugins/PHPMailer/PHPMailerAutoload.php');
		}
        if(file_exists('plugins/phpexcel/'.$classe.'.php')){
            require_once('plugins/phpexcel/'.$classe.'.php');
        }
        if(file_exists('plugins/datatables/'.$classe.'.class.php')){
            require_once( 'plugins/datatables/'.$classe.'.class.php');
        }
    }
    spl_autoload_register('autoload');
