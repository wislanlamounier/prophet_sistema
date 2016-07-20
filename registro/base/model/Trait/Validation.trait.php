<?php

	trait Validation {

		public function validNumber($input){
			return filter_var($input, FILTER_VALIDATE_INT) || $input == 0;
		}

		public function validEmail($input){
			return filter_var($input, FILTER_VALIDATE_EMAIL);
		}

		public function notSpecials($input){
			return filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS) == $input;
		}

		public function notEmpty($input){
			return trim($input) != '';
		}

		public function validCpf($input){
            $input = ereg_replace('[^0-9]', '', $input);
            $input = str_pad($input, 11, '0', STR_PAD_LEFT);


            if (strlen($input) != 11) {
                return false;
            }else{

                for ($t = 9; $t < 11; $t++) {

                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $input{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($input{$c} != $d) {
                        return false;
                    }
                }
                return true;
            }
		}

		public function validDate($input){
			$input = explode('-', $input);

			if(count($input) == 3){
				if(checkdate($input[1], $input[2], $input[0])){
					return true;
				}
			}
			return false;
		}

		public function validTime($input){
			$input = explode(':', $input);
			if(count($input) == 2){
				if(($input[0] < 24) && ($input[1] < 60)){
					return true;
				}
			}
			elseif(count($input) == 3){
				if(($input[0] < 24) && ($input[1] < 60) && ($input[2] < 60)){
					return true;
				}
			}
		}

		public function validDatetime($input){
			$input = explode(' ', $input);
			if(count($input) != 2)
				return false;
			if(!$this->validacaoData($input[0]))
				return false;
			if(!$this->validacaoHorario($input[1]))
				return false;
			return true;
		}

		public function validUf($input){
			$input = strtoupper($input);
			$arrUF = array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");

			return array_key_exists($input, $arrUF);
		}

		public function validCnpj($input){
            $j=0;
			for($i=0; $i<(strlen($input)); $i++){
				if(is_numeric($input[$i])){
					$num[$j]=$input[$i];
					$j++;
				}
			}
			if(!isset($num)){
			    $isCnpjValid = false;
			}else{
    			if(count($num)!=14){
					return false;
				}

    			if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0){
    			    $isCnpjValid=false;
    			}
    			else{
    				$j=5;
    				for($i=0; $i<4; $i++){
    					$multiplica[$i]=$num[$i]*$j;
    					$j--;
    				}
    				$soma = array_sum($multiplica);
    				$j=9;
    				for($i=4; $i<12; $i++){
    					$multiplica[$i]=$num[$i]*$j;
    					$j--;
    				}
    				$soma = array_sum($multiplica);
    				$resto = $soma%11;
    				if($resto<2){
    					$dg=0;
    				}
    				else{
    					$dg=11-$resto;
    				}
    				if($dg!=$num[12]){
    					$isCnpjValid=false;
    				}
    			}
    			if(!isset($isCnpjValid)){
					$j=6;
					for($i=0; $i<5; $i++){
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=5; $i<13; $i++){
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
					$soma = array_sum($multiplica);
					$resto = $soma%11;
					if($resto<2){
						$dg=0;
					}
					else{
						$dg=11-$resto;
					}
					if($dg!=$num[13]){
						$isCnpjValid=false;
					}
					else{
						$isCnpjValid=true;
					}
				}
			}
			return $isCnpjValid;
		}

		public function validFile($input, $types){
			$extension = explode('.', $input);
			if(count($extension) < 2)
				return false;
            $extension = strtolower($extension[count($extension)-1]);

            return in_array($extension, $types);
		}

		public function existsForeign($table, $input){
			if($table == 'cliente'){
	    		Connection::closeConnection();
				$model = new ClientModel(true, 'u444069746_bnet', 'u444069746_bnet', 'bn2412');
				return $model->exists($table, 'cdnCliente', $input);
			}else{
				$model = debug_backtrace()[2]['object'];
				return $model->exists($table, 'id', $input);
			}
		}

	}
