<?php


    class RegisterController extends AppController{

        public function user(){
            if($this->request()){
                if($this->model->user()){
                    unset($_POST);
                    $this->clinic();
                }else{
                    unset($_POST);
                    $this->user();
                }
                return;
            }
            $this->viewer->show('user', 'Cadastro', false);
            return;
        }
        
        public function clinic(){
            if(!isset($_SESSION['current_id'])){
                unset($_POST);
                return $this->user();
            }
            if($this->request()){
                if($this->model->clinic()){
                    $this->finish();
                }else{
                    unset($_POST);
                    $this->clinic();
                }
                return;
            }
            $this->viewer->show('clinic', 'Finalização de cadastro', false);
            return;
        }
        
        public function finish(){
            if($this->request()){
                echo $this->viewer->show('finish', 'Fim', false);
            }
        }
        
    }
