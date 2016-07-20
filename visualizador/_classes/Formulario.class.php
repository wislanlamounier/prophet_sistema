<?php

    /**
     * Classe responsável pela geração de formulários dinâmicos
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-13
     *
    **/
    class Formulario {

        private $html;
        private $action;
        private $method;
        private $upload;
        private $id;

        /**
         * Método construtor da classe.
         * @param String $action  - redirecionamento do formulário
         * @param String $method  - método do formulário (get/post)
         * @param Boolean $upload - permitir envio de arquivo
         *
        **/
        public function __construct($action, $method, $upload, $id = 'form'){
            $this->setAction($action);
            $this->setMethod($method);
            $this->setUpload($upload);
            $this->setId($id);
            $this->iniciar();
        }

        /**
        * Método que retorna valor da variavel action
        *
        * @return String - valor da variável action
        *
        */
        public function getAction() {
            return $this->action;
        }

        /**
        * Método que seta valor da variavel action
        *
        * @param String $action - valor da variável action
        *
        */
        public function setAction($action){
            $this->action = $action;
        }

        /**
    	* Método que retorna valor da variavel method
    	*
    	* @return String - valor da variável method
    	*
    	*/
    	public function getMethod() {
    		return $this->method;
     	}

    	/**
    	* Método que seta valor da variavel method
    	*
    	* @param String $method - valor da variável method
    	*
    	*/
    	public function setMethod($method){
    		$this->method = $method;
    	}

    	/**
    	* Método que retorna valor da variavel upload
    	*
    	* @return String - valor da variável upload
    	*
    	*/
    	public function getUpload() {
    		return $this->upload;
     	}

    	/**
    	* Método que seta valor da variavel upload
    	*
    	* @param String $upload - valor da variável upload
    	*
    	*/
    	public function setUpload($upload){
    		$this->upload = $upload;
    	}

        /**
         * Método responsável por setar a id do formulário
         *
         * @param String $id - id do formulário
         *
        **/
        public function setId($id){
            $this->id = $id;
        }

        /**
         * Método reponsável por retornar a id do formulário
         *
         * @return String - id do formulário
         *
        **/
        public function getId(){
            return $this->id;
        }

        /**
         * Método responsável por criar o formulário
         * dinâmico.
         *
        **/
        public function iniciar(){
            $this->formulario = '<form id="'.$this->getId().'" action="'.$this->getAction().'" method="'.$this->getMethod().'" ';
            if($this->getUpload()){
                $this->formulario .= 'enctype="multipart/form-data"';
            }
            $this->formulario .= ">".PHP_EOL;
        }

        /**
         * Método responsável por adicionar um campo no formulário.
         *
         * @param Integer $tamColuna - tamanho da coluna do bootstrap. Valores de 1 à 12.
         * @param String $type - tipo do campo do formulário.
         * @param String $name - nome do campo do formulário.
         * @param String $id   - id do campo do formulário.
         * @param Integer $maxLength - caracteres máximos
         * @param String $label - label do campo (opcional).
         * @param String $placeholder - placeholder do campo (opcional).
         * @param String $classes - classes do campo (opcional).
         * @param String $value - valor inicial do campo (opcional).
         * @param Boolean $required - campo é obrigatório (opcional).
         * @param Boolean $disabled - campo está disabled.
         *
        **/
        public function addInput($tamColuna, $type, $name, $id, $maxLength = 0, $label = '', $placeholder = '', $classes = '', $value = '', $required = false, $disabled = false){
            $this->formulario .= '
                                    <div class="col-md-'.$tamColuna.' ">
                                    <div class="form-group">';
            if($label != ''){
                $this->formulario .= '            <label class="control-label" for="'.$name.'" id="lbl'.ucfirst($id).'">'.$label.'</label>';
            }
            if($value != ''){
                $value = ' value="'.$value.'" ';
            }
            $classes .= ' form-control';
            if($maxLength != 0)
                $maxLength = 'maxlength="'.$maxLength.'"';
            else
                $maxLength = '';
            $this->formulario .= '            <input '.$maxLength.' class="'.trim($classes).'"'.$value.'type="'.$type.'" name="'.$name.'" id="'.$id.'" ';
            if($placeholder != ''){
                $this->formulario .= 'placeholder="'.$placeholder.'"';
            }
            if($required){
                $this->formulario .= 'required';
            }
            if($disabled){
                $this->formulario .= ' disabled ';
            }
            $this->formulario .= '>
                        </div>
                    </div>
                ';
        }

        /**
         * Método responsável por adicionar um select no formulário
         *
         * @param Integer $tamSelect - tamanho do select
         * @param String $classes - estilos do select (opcional).
         * @param String $id - id do select.
         * @param String $name - nome do select.
         * @param String $label - label do select
         * @param Array $options - opcoes do select no seguinte formato:
         *                         array ( 'valorDoOption' => 'Label do Option' ).
         * @param Boolean $required - campo é obrigatório (opcional).
         * @param String $selecionado - option já selecionado
         *
        **/
        public function addSelect($tamSelect, $classes = '', $id, $name, $label, $options, $required, $selecionado = ''){
            $classes = trim($classes.' form-control');
            $this->formulario .= PHP_EOL.'<div class="col-md-'.$tamSelect .'" id="coluna'.ucfirst($id).'">';
            $this->formulario .= PHP_EOL.'    <div class="form-group">';
            $this->formulario .= PHP_EOL.'        <label class="control-label" for="'.$name.'" id="lbl'.ucfirst($id).'">'.$label.'</label>';
            $this->formulario .= PHP_EOL.'        <select class="'.$classes.'" name="'.$name.'" id="'.$id.'" ';
            if($required){
                $this->formulario .= 'required';
            }
            $this->formulario .= '>'.PHP_EOL;
            
            foreach($options as $valor=>$texto){
                $this->formulario .= '          <option ';
                if($valor == $selecionado)
                    $this->formulario .= 'selected';
                $this->formulario .= ' value="'.$valor.'">'.$texto.'</option>'.PHP_EOL;
            }
            $this->formulario .= PHP_EOL.'        </select/>';
            $this->formulario .= PHP_EOL.'    </div>';
            $this->formulario .= PHP_EOL.'</div>';
        }

        /**
         * Método responsável por adicionar um textarea no formulário
         *
         * @param Integer $tamText - tamanho do textarea
         * @param String $id - id do textarea.
         * @param String $name - nome do textarea.
         * @param String $label - label do textarea
         * @param String $placeholder - placeholder do textarea
         * @param String $classes - estilos do textarea (opcional).
         * @param Boolean $required - campo é obrigatório (opcional).
         * @param String $value - valor do campo (opcion).
         *
        **/
        public function addTextarea($tamText, $id, $name, $label, $placeholder, $classes = '', $required = false, $value = ''){
            if($classes != ''){
                $classes = ' class="form-control '.$classes.'" ';
            }else{
                $classes = ' class="form-control" ';
            }
            $this->formulario .= PHP_EOL.'<div class="col-md-'.$tamText.'" id="coluna'.ucfirst($id).'">';
            $this->formulario .= PHP_EOL.'    <div class="form-group">';
            $this->formulario .= PHP_EOL.'        <label class="control-label" for="'.$name.'" id="lbl'.ucfirst($id).'">'.$label.'</label>';
            if($required){
                $required = 'required';
            }else{
                $required = '';
            }
            $this->formulario .= PHP_EOL.'        <textarea name="'.$name.'" id="'.$id.'"'.$classes.'" placeholder="'.$placeholder.'" '.$required.'>'.$value.'</textarea>';
            $this->formulario .= PHP_EOL.'    </div>';
            $this->formulario .= PHP_EOL.'</div>';
        }

        /**
         * Método responsável por adicionar um botão no formulário
         *
         * @param Integer $tamBotao - tamanho do botão.
         * @param String $type - tipo do botão.
         * @param String $classes - estilos do botão.
         * @param String $id - id do botão.
         * @param String $name - nome do botão.
         * @param String $label - label do botão.
         * @param String $fa - icone do botão pelo font awesome (opcional).
         *
        **/
        public function addButton($tamBotao, $type, $classes, $id, $name, $label, $fa = ''){
            $this->formulario .= PHP_EOL.'<div class=" col-md-'.$tamBotao.'" id="coluna'.ucfirst($id).'">
                <button name="'.$name.'" type="'.$type.'" class="'.$classes.'" id="'.$id.'">';
            if($fa != ''){
                $this->formulario .= '  <span class="fa fa-'.$glyphicon.'"></span>';
            }
            $this->formulario .= '    '.$label.'
                </button>
            </div>
            ';
        }

        /**
         * Método responsável por adicionar uma checkbox ao formulário
         *
         * @param Integer $tamColuna - tamanho da coluna do bootstrap. Valores de 1 à 12.
         * @param String $name - nome do campo do formulário.
         * @param String $id   - id do campo do formulário.
         * @param String $label - label do campo (opcional).
         * @param String $classes - classes do campo (opcional).
         * @param Boolean $checked - deve iniciar já selecionado (opcional).
         *
        **/
        public function addCheckbox($tamColuna, $name, $id, $label = '', $classes = '', $checked = false){
            $this->formulario .= '
                                    <div class="col-md-'.$tamColuna.'">
                                    <div class="form-group">';
            if($label != ''){
                $this->formulario .= '            <label class="control-label" for="'.$name.'" id="lbl'.ucfirst($id).'">'.$label.'</label><br>';
            }
            $checked = $checked ? 'checked' : '';
            $this->formulario .= '            <input class="'.trim($classes).'" '.$checked.' type="checkbox" name="'.$name.'" id="'.$id.'" ';
            $this->formulario .= '>
                        </div>
                    </div>
                ';
        }

        /**
         * Método responsável por colocar o botão de final de formulário
         *
         * @param String $texto - texto que deve aparecer
         * @param String $classe - tipo do botão (primary/success)
         *
        **/
        public function addBotaoFim($texto, $classe){
            $this->formulario .= '<div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" name="botaofim" class="btn btn-block btn-lg btn-'.$classe.'">
                    '.$texto.'
                </button>
            </div></div>';
        }

        /**
         * Método responsável por colocar uma freeform string no formulário
         *
         * @param String $freeform - string para adicionar no formulário
         *
        **/
        public function addFree($freeform){
            $this->formulario .= PHP_EOL.$freeform.PHP_EOL;
        }

        /**
         * Método responsável por retornar as classes necessárias ao input
         * 
         * @param String $type - tipo do input
         *
        **/
        public function getClasses($type){
            $classes = '';
            switch ($type) {
                case 'cpf':
                    $classes .= ' mask-cpf ';
                    break;
                
                case 'cnpj':
                    $classes .= ' mask-cnpj ';
                    break;

                case 'cpfcnpj':
                    $classes .= ' mask-cpfcnpj ';
                    break;

                case 'date':
                    $classes .= ' mask-date ';
                    break;

                case 'cep':
                    $classes .= ' mask-cep ';
                    break;

                case 'moeda':
                    $classes .= ' mask-money ';
                    break;

                case 'hora':
                    $classes .= ' mask-time ';
                    break;

                case 'datetime':
                    $classes .= ' mask-datetime ';
                    break;

                case 'phone':
                    $classes .= ' mask-phone ';
                    break; 

                default:
                    break;
            }
            return $classes;
        }

        /**
         * Método reponsável por retornar as options de um select
         *
         * @param Array $campos - campos que irão ser options
         * @return Array - options do select
         *
        **/
        public function getOptions($campos){
            $options = array();
            foreach($campos as $campo){
                $options[$campo['nomCampo']] = $campo['desLabel'];
            }
            return $options;
        }

        /**
         * Método responsável por finalizar o formuluário
         * e retorná-lo
         *
         * @return String - formulário
         *
        **/
        public function fimForm(){
            $this->formulario .= PHP_EOL.'</form>';
            return $this->formulario;
        }
    }
