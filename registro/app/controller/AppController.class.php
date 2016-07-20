<?php

    /**
     * Use this class to extends your controllers.
     * Here you can implements your own methods to all of your controllers.
     *
    **/
    class AppController extends Controller{
        private $user;

        public function __construct(){
            parent::__construct();
            $className = substr(get_class(debug_backtrace()[0]['object']), 0, -10);
            $model = $className.'Model';
            $viewer = $className.'Viewer';

            if(class_exists($model))
                eval('$this->model = new '.$model.'();');
            if(class_exists($viewer))
                eval('$this->viewer = new '.$viewer.'();');
            $this->user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
        }

    	public function logged(){
    		return isset($_SESSION['logged']);
    	}

    	static function staticLogged(){
			$logged = false;
			if(isset($_SESSION['logged'])){
				if(!is_null($_SESSION['logged'])){
					$logged = true;
				}
			}
			if(!$logged){
				$_SESSION['flash']['danger'][] = _LOGIN_NEED;
				Controller::siteIndex();
				die;
			}
    	}

        public function setUser($user){
            $this->user = $user;
        }

        public function user(){
            return $this->user;
        }

        public function model(){
            return $this->model;
        }

    }

?>
