<?php

    /**
     * Realizes the communication between the model and the viewer
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-06-30
     *
    **/
    class Controller {

        public $model;
        public $viewer;

        /**
         * Constructor method
         *
        **/
        public function __construct(){
            $this->model = new Model();
            $this->viewer = new Viewer();
        }

        /**
         * Redirect to an specified page
         *
         * @param String $url - url of the page
         *
        **/
        public function redirect($url){
            header('Location: '.$url);
        }

        /**
         * Redirects user to index.
         *
        **/
        static function siteIndex(){
            eval('$controller = new '._MAIN_CLASS.'();');
	        $controller->{_MAIN_METHOD}();
        }

        /**
         * Method used for register a log
         *
         * @param Array $log - Format = array('type', 'operation', 'module', 'id user')
         * @return Boolean - true if success, false if error
         *
        **/
        public function log($log){
            date_default_timezone_set('Brazil/East');
            $type = strtoupper($log[0]);
            $operation = strtoupper($log[1]);
            $module = strtoupper($log[2]);
            if(isset($log[3]))
            	$id = $log[3];
            else
            	$id = 'SYSTEM';
            $date = date('Y-m-d H:i:s');

            if(isset($_SESSION[$id])){
            	$id = $_SESSION[$id];
            }

        	$log = array(
        					'user'  => $campo,
        					'date'      => $data,
        					'type'     => $tipo,
        					'operation' => $operacao,
        					'module'   => $modulo
        				);
        	if(!$this->modelo->inserir('log', $log)){
        		$this->viewer->flash(_LOG_ERROR);
        		return false;
        	}
        	return true;
        }

        /**
         * Method used to detect if exists an request by post
         *
         * @return Boolean - requests exists.
         *
        **/
        public function request(){
            if(isset($_POST)){
                if(count($_POST) > 0)
                    return true;
            }
            return false;
        }
    }
