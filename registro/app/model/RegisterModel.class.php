<?php

class RegisterModel extends AppModel {

    public function getUser($id) {
        return $this->getDto('user', 'cdnUsuario', $id);
    }

    public function user() {
        $mesErro = '';
        if (!isset($_POST['email'])) {
            $mesErro .= 'Informe um e-mail para continuar o cadastro.<br>';
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $mesErro .= 'Informe um e-mail válido.<br>';
            }
        }

        if (!isset($_POST['name'])) {
            $mesErro .= 'Informe um nome para continuar o cadastro.<br>';
        }

        if (!isset($_POST['password'])) {
            $mesErro .= 'Informe uma senha para continuar o cadastro.<br>';
        }

        if (!isset($_POST['passwordConfirm'])) {
            $mesErro .= 'Confirme a sua senha.<br>';
        }

        if ($mesErro == '') {
            if ($_POST['password'] != $_POST['passwordConfirm']) {
                $mesErro .= 'Senhas não conferem.<br>';
            }
        }

        if ($mesErro != '') {
            parent::caller()->viewer->flash($mesErro, 'e');
            return false;
        }

        if ($this->exists('usuario', 'strEmail', $_POST['email'])) {
            $user = $this->getDto('user', 'strEmail', $_POST['email']);
            if (is_null($user->get('cdnClinica'))) {
                $_SESSION['current_id'] = $user->get('cdnUsuario');
                parent::caller()->viewer->flash('Opa! Parece que você já iniciou um cadastro em nosso sistema!', 's');
                return true;
            } else {
                parent::caller()->viewer->flash('Você já é cadastrado em nosso sistema :(', 'e');
                return false;
            }
        } else {

            $user = new User();
            $user->set('strEmail', $_POST['email']);
            $user->set('strSenha', $_POST['password']);
            $user->set('nomUsuario', $_POST['name']);
            if ($this->insert('usuario', $user)) {
                $_SESSION['current_id'] = $this->lastInserted('usuario');

                return true;
            } else {
                return false;
            }
        }
    }

    public function clinic() {
        $mesErro = '';
        $clinic = new Clinic();
        if (!isset($_POST['name'])) {
            $mesErro .= 'Informe o nome da clínica.<br>';
        } else {
            $clinic->set('nomClinica', $_POST['name']);
        }

        if (!isset($_POST['email'])) {
            $mesErro .= 'Informe um e-mail de contato para a clínica.<br>';
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $mesErro .= 'Informe um e-mail de contato válido para a clínica.<br>';
            } else {
                $clinic->set('strEmail', $_POST['email']);
            }
        }

        if (!isset($_POST['document'])) {
            $mesErro .= 'Informe o CPF/CNPJ que será utilizado para a clínica.<br>';
        } else {
            if ($clinic->validCpf($_POST['document'])) {
                $clinic->set('indFisica', 1);
                $clinic->set('codCpfCnpj', $_POST['document']);
            } elseif ($clinic->validCnpj($_POST['document'])) {
                $clinic->set('indFisica', 0);
                $clinic->set('codCpfCnpj', $_POST['document']);
            } else {
                $mesErro .= 'Informe um documento válido para a clínica.<br>';
            }
        }

        if(!isset($_POST['cro'])){
            $mesErro .= 'Informe seu CRO.<br>';
        }else{
            $clinic->set('codCroPrimeiro', $_POST['cro']);
        }

        if(!isset($_POST['phone'])){
            $mesErro .= 'Informe seu telefone.<br>';
        }else{
            $clinic->set('numTelefone1', $_POST['phone']);
        }
        
        $clinic->set('desTamanhoClinica', $_POST['size']);


        if ($mesErro != '') {
            parent::caller()->viewer->flash($mesErro, 'e');
            return false;
        }

        if ($this->exists('clinica', 'codCpfCnpj', $clinic->get('codCpfCnpj'))) {
            $this->delete('usuario', array('cdnUsuario' => $_SESSION['current_id']));
            parent::caller()->viewer->flash('Este documento já está em uso no sistema! :(', 'e');
            return false;
        } else {
            $clinic->set('cdnUsuario', $_SESSION['current_id']);
            $clinic->set('nomBanco', uniqid());
            if ($this->insert('clinica', $clinic)) {
                $cdnClinica = $this->lastInserted('clinica');
                $user = $this->getUser($_SESSION['current_id']);
                $user->set('cdnClinica', $cdnClinica);
                if (!$this->update('usuario', $user, array('cdnUsuario' => $_SESSION['current_id']))) {
                    parent::caller()->viewer->flash(_INSERT_ERROR, 'e');
                    $this->delete('clinica', array('cdnClinica' => $cdnClinica));
                    return false;
                }
                
                $this->query('insert into prophet_main.configuracoes (cdnClinica) values ('.$cdnClinica.')');
                
                $this->copyDb($clinic->get('nomBanco'));
                $this->query('insert into prophet_'.$clinic->get('nomBanco').'.usuario_master (cdnUsuario) VALUES ('.$_SESSION['current_id'].')');
                return true;
            } else {
                parent::caller()->viewer->flash(_INSERT_ERROR, 'e');
                return false;
            }
        }
    }

    public function copyDb($database) {
        $database = 'prophet_'.$database;
        if($_SERVER['HTTP_HOST'] == 'localhost:8090'){
            $dir = trim('C:\xampp\mysql\bin\ ');
            $pass = '';
        }else{
            $dir = '';
            $pass = '-pbentonet2412';
        }
        system($dir.'mysqldump -u root '.$pass.' prophet_model > model.sql', $ret);
        system($dir.'mysql -u root '.$pass.' -e "create database if not exists '.$database.'"', $ret);
        system($dir.'mysql -u root '.$pass.' '.$database.' < model.sql', $ret);
        
    }

}
