<?php

	trait Masks{
		
		public function dateMask($input){
			return date('d/m/Y', strtotime($input));
		}

		public function datetimeMask($input){
			return date('d/m/Y H:i:s', strtotime($input));
		}

		public function ufMask($input){
			$input = strtoupper($input);
			$ufs   = array("AC"=>"Acre",
						   "AL"=>"Alagoas",
						   "AM"=>"Amazonas",
						   "AP"=>"Amapá",
						   "BA"=>"Bahia",
						   "CE"=>"Ceará",
						   "DF"=>"Distrito Federal",
						   "ES"=>"Espírito Santo",
						   "GO"=>"Goiás",
						   "MA"=>"Maranhão",
						   "MT"=>"Mato Grosso",
						   "MS"=>"Mato Grosso do Sul",
						   "MG"=>"Minas Gerais",
						   "PA"=>"Pará",
						   "PB"=>"Paraíba",
						   "PR"=>"Paraná",
						   "PE"=>"Pernambuco",
						   "PI"=>"Piauí",
						   "RJ"=>"Rio de Janeiro",
						   "RN"=>"Rio Grande do Norte",
						   "RO"=>"Rondônia",
						   "RS"=>"Rio Grande do Sul",
						   "RR"=>"Roraima",
						   "SC"=>"Santa Catarina",
						   "SE"=>"Sergipe",
						   "SP"=>"São Paulo",
						   "TO"=>"Tocantins");

			return $ufs($input);
		}

	    public function accentOffMask($input, $enc = "UTF-8"){

	        $accents = array(
	            'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
	            'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
	            'C' => '/&Ccedil;/',
	            'c' => '/&ccedil;/',
	            'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
	            'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
	            'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
	            'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
	            'N' => '/&Ntilde;/',
	            'n' => '/&ntilde;/',
	            'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
	            'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
	            'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
	            'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
	            'Y' => '/&Yacute;/',
	            'y' => '/&yacute;|&yuml;/',
	            'a.' => '/&ordf;/',
	            'o.' => '/&ordm;/'
	        );

	        return preg_replace($accents,array_keys($accents),htmlentities($input,ENT_NOQUOTES, $enc));
	    }

	    public function monthNameMask($input){
	        switch ($input) {
	                case "01":    $input = 'Janeiro';     break;
	                case "02":    $input = 'Fevereiro';   break;
	                case "03":    $input = 'Março';       break;
	                case "04":    $input = 'Abril';       break;
	                case "05":    $input = 'Maio';        break;
	                case "06":    $input = 'Junho';       break;
	                case "07":    $input = 'Julho';       break;
	                case "08":    $input = 'Agosto';      break;
	                case "09":    $input = 'Setembro';    break;
	                case "10":    $input = 'Outubro';     break;
	                case "11":    $input = 'Novembro';    break;
	                case "12":    $input = 'Dezembro';    break;
	         }

	         return $input;
	    }

	    public function passwordMask($input){
	    	return crypt($input, '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
	    }

	    public function getDto($table, $id){
	    	if($table == 'cliente'){
	    		Connection::closeConnection();
				$model = new ClientModel(true, 'u444069746_bnet', 'u444069746_bnet', 'bn2412');
				$client = $model->getDto($table, 'cdnCliente', $id);
				Connection::restartConnection();
				return $client;
	    	}else{
		    	$model = new Model();
		    	return $model->getDto($table, 'id', $id);
		    }
	    }

	}
