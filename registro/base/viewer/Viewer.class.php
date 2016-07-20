<?php

    /**
     * Class used for show pages in screen
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-06-30
     *
    **/
    class Viewer {
        private $variables = array();
        private $css;
        private $js;
        private $called;
        private $fullPages = array('login');
        private $Form;


		/**
		 * Constructor method
		 *
		**/
        public function __construct() {
            $this->Form = new Form();
            $this->set('css', '');
            $this->set('js', '');
        }

		/**
		 * Used to include html in screen
		 *
		 * @param String $page - page name
		 * @param String $title - TITLE tag in html
		 * @param Boolean $needLogin - page need login? Default: true
		 *
		**/
        public function show($page, $title, $needLogin = true){

            if(isset($_SESSION['user'])){
                $this->set('actualUser', unserialize($_SESSION['user']));
            }

            if(is_array($this->js)){
                $js = implode(PHP_EOL, $this->js);
                $this->set('js', $js);
            }
            if(is_array($this->css)){
                $css = implode(PHP_EOL, $this->css);
                $this->set('css', $css);
            }
            $this->set('title', $title);

            foreach($this->variables as $var =>$value){
                global $$var;
                $$var = $value;
            }

            $folder = $this->getCalled(debug_backtrace());
            $this->called = $folder;

            if($needLogin)
            	include(_CONFIG_ROOT_DIR.'/check/logged.inc.php');

            if(!in_array($page, $this->fullPages))
                include(_APP_ROOT_DIR.'viewer/default/header.php');

    		echo PHP_EOL;
            if(file_exists(_APP_ROOT_DIR.'viewer/'.$folder.'/'.$page.'.php')){
                include (_APP_ROOT_DIR.'viewer/'.$folder.'/'.$page.'.php');
            }else{
                if(file_exists(_APP_ROOT_DIR.'viewer/default/404.php'))
                    include (_APP_ROOT_DIR.'viewer/default/404.php');
                else
                    include (_BASE_ROOT_DIR.'viewer/views/404.php');
            }
    		echo PHP_EOL;
            if(!in_array($page, $this->fullPages))
                include(_APP_ROOT_DIR.'viewer/default/footer.php');
        }


		/**
		 * Set a global variable
		 *
		 * @param String $variable - var name
		 * @param Mixed $value - var value
		 *
		**/
        public function set($variable, $value){
            $this->variables[$variable] = $value;
        }

		/**
		 * Add a CSS file to the html
		 *
		 * @param String $filename - name of the css file
		 *
		**/
        public function addCSS($filename){
            $this->css[] = '<link href="'.$filename.'" rel="stylesheet"/>';
        }


		/**
		 * Add JS file to the html
		 *
		 * @param String $filename - name of the JS file
		 *
		**/
        public function addJS($filename){
            $this->js[] = '<script type="text/javascript" src="'.$filename.'"></script>';
        }

        /**
         * Get the caller class name
         *
         * @param Array $backtrace - debug_backtrace()
         * @return String - name of the caller class
         *
        **/
        public function getCalled($backtrace){
        	$called = $backtrace[0]['file'];
        	$called = explode(_DS, $called);
        	$called = $called[count($called) - 1];
        	$called = explode('.', $called);
        	$called = $called[0];
            $length = strlen($called) - 10;
        	return substr($called, 0, $length);
        }

        /**
         * Method used to set a flash message
         *
         * @param String $message - message to be displayed.
         * @param String $type - message type, s: success
         *                                     e: error
         *                                     w: warning
         *                                     i: information. Default: i
         *
        **/
        public function flash($message, $type = 'i'){
            $validTypes = array(
                's',
                'e',
                'w',
                'i'
            );
            $classes = array(
                's' => 'success',
                'e' => 'danger',
                'w' => 'warning',
                'i' => 'info'
            );
            if(!in_array($type, $validTypes))
                $type = 'i';

            $_SESSION['flash'][$classes[$type]][] = $message;
        }

        /**
         * Method used to return the flashes
         *
         * @return Array - array of flashes
         *
        **/
        public function getFlash(){
            if(!isset($_SESSION['flash'])){
                $_SESSION['flash'] = array();
            }else{
                if(!is_array($_SESSION['flash'])){
                    $msg = $_SESSION['flash'];
                    if(trim($msg) != ''){
                        $_SESSION['flash']['i'] = $msg;
                    }else{
                        $_SESSION['flash'] = array();
                    }
                }
            }
            $have = false;
            foreach($_SESSION['flash'] as $type => $flashes){
                if(is_array($flashes)){
                    if(count($flashes) > 0)
                        $have = true;
                }
            }
            if(!$have)
                return false;

            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);

            return $flash;
        }

    }
