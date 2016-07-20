<?php

	/**
	 * Files autoload
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @param String $class - called class name
	 *
	**/
    function autoload($class){
		// Base MVC
    	if(file_exists(_BASE_ROOT_DIR.'controller/'.$class.'.class.php')){
    		include_once(_BASE_ROOT_DIR.'controller/'.$class.'.class.php');
    	}
		if(file_exists(_BASE_ROOT_DIR.'model/'.$class.'.class.php')){
    		include_once(_BASE_ROOT_DIR.'model/'.$class.'.class.php');
    	}
		if(file_exists(_BASE_ROOT_DIR.'viewer/'.$class.'.class.php')){
    		include_once(_BASE_ROOT_DIR.'viewer/'.$class.'.class.php');
    	}

		// Traits
		if(file_exists(_BASE_ROOT_DIR.'model/Trait/'.$class.'.trait.php')){
    		include_once(_BASE_ROOT_DIR.'model/Trait/'.$class.'.trait.php');
    	}
    	if(file_exists(_APP_ROOT_DIR.'model/Trait/'.$class.'.trait.php')){
    		include_once(_BASE_ROOT_DIR.'model/Trait/'.$class.'.trait.php');
    	}
    	if(file_exists(_APP_ROOT_DIR.'model/trait/'.$class.'.trait.php')){
    		include_once(_BASE_ROOT_DIR.'model/trait/'.$class.'.trait.php');
    	}

		// App classes
		if(file_exists(_APP_ROOT_DIR.'controller/'.$class.'.class.php')){
			include_once(_APP_ROOT_DIR.'controller/'.$class.'.class.php');
		}
		if(file_exists(_APP_ROOT_DIR.'model/'.$class.'.class.php')){
			include_once(_APP_ROOT_DIR.'model/'.$class.'.class.php');
		}
		if(file_exists(_APP_ROOT_DIR.'model/dto/'.$class.'.class.php')){
			include_once(_APP_ROOT_DIR.'model/dto/'.$class.'.class.php');
		}
		if(file_exists(_APP_ROOT_DIR.'viewer/'.$class.'.class.php')){
			include_once(_APP_ROOT_DIR.'viewer/'.$class.'.class.php');
		}
    }
    spl_autoload_register('autoload');
