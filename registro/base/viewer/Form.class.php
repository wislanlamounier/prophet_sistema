<?php

    /**
     * Class used to help the creation of forms
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2016-03-20
     *
    **/
    class Form {

        public static function makeForm($dto, $view = false){
            $form = '';

            foreach($dto->get('FieldsForm') as $field => $opts){
                if($view){
                    if(strpos('passwordConfirm', $field) === 0)
                        continue;
                }
                $call = '$field, $opts["label"]';
                if(isset($opts['opts'])){
                    $call .= ', $opts["opts"]';
                    if(isset($opts['other'])){
                        if($view)
                            $opts['other']['disabled'] = 'disabled';
                        $call .= ', $opts["other"]';
                    }else{
                        if($view)
                            $call .= ', array("disabled" => "disabled")';
                    }
                }else{
                    if(isset($opts['other'])){
                        if($view)
                            $opts['other']['disabled'] = 'disabled';
                        $call .= ', array(), $opts["other"]';
                    }else{
                        $call .= ', array(), array("disabled" => "disabled")';
                    }
                }
                eval('$form .= self::input('.$call.');');
            }
            return $form;
        }

        public function input($name, $label, $opts = array(), $other = array()){
            $type = isset($opts['type']) ? $opts['type'] : 'text';
            switch ($type) {
                case 'textarea':
                    return self::textarea($name, $label, $opts, $other);
                    break;

                case 'radio':
                break;

                case 'checkbox':
                break;

                case 'select':
                break;

                default:
                # code...
                break;
            }
            $classes = isset($opts['class']) ? $opts['class'] : '';
            $size = isset($opts['size']) ? $opts['size'] : 6;


            $otherStr = '';
            foreach($other as $prop => $val){
                $otherStr .= $prop.'="'.$val.'"';
            }

            $input = '
                <div class="col-sm-'.$size.' form-group">
                    <label for="'.$name.'" class="control-label">'.$label.'</label>
                    <input '.$otherStr.' type="'.$type.'" name="'.$name.'" class="form-control '.$classes.'" />
                </div>
            ';
            return $input;
        }

        public function textarea($name, $label, $opts = array(), $other = array()){
            $classes = isset($opts['class']) ? $opts['class'] : '';
            $size = isset($opts['size']) ? $opts['size'] : 6;

            $otherStr = '';
            $value = '';
            foreach($other as $prop => $val){
                if($prop == 'value'){
                    $value = $val;
                    continue;
                }
                $otherStr .= $prop.'="'.$val.'"';
            }

            $input = '
                <div class="col-sm-'.$size.' form-group">
                    <label for="'.$name.'" class="control-label">'.$label.'</label>
                    <textarea '.$otherStr.' name="'.$name.'" class="form-control '.$classes.'">'.$value.'</textarea>
                </div>
            ';
            return $input;
        }
    }
