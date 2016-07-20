<?php

    trait Transformacao {

        public function transformacaoData($entrada) {
            return date('d/m/Y', strtotime($entrada));
        }

        public function transformacaoDatetime($entrada) {
            return date('d/m/Y H:i:s', strtotime($entrada));
        }

        public function transformacaoUf($entrada) {
            $entrada = strtoupper($entrada);
            $arrUF = array(
                "AC" => "Acre",
                "AL" => "Alagoas",
                "AM" => "Amazonas",
                "AP" => "Amapá",
                "BA" => "Bahia",
                "CE" => "Ceará",
                "DF" => "Distrito Federal",
                "ES" => "Espírito Santo",
                "GO" => "Goiás",
                "MA" => "Maranhão",
                "MT" => "Mato Grosso",
                "MS" => "Mato Grosso do Sul",
                "MG" => "Minas Gerais",
                "PA" => "Pará",
                "PB" => "Paraíba",
                "PR" => "Paraná",
                "PE" => "Pernambuco",
                "PI" => "Piauí",
                "RJ" => "Rio de Janeiro",
                "RN" => "Rio Grande do Norte",
                "RO" => "Rondônia",
                "RS" => "Rio Grande do Sul",
                "RR" => "Roraima",
                "SC" => "Santa Catarina",
                "SE" => "Sergipe",
                "SP" => "São Paulo",
                "TO" => "Tocantins"
            );

            return $arrUF[$entrada];
        }

        public function transformacaoTiraAcento($string, $slug = false) {

            $slug = false;
            // Código ASCII das vogais
            $ascii['a'] = range(224, 230);
            $ascii['e'] = range(232, 235);
            $ascii['i'] = range(236, 239);
            $ascii['o'] = array_merge(range(242, 246), array(240, 248));
            $ascii['u'] = range(249, 252);
            // Código ASCII dos outros caracteres
            $ascii['b'] = array(223);
            $ascii['c'] = array(231);
            $ascii['d'] = array(208);
            $ascii['n'] = array(241);
            $ascii['y'] = array(253, 255);
            foreach ($ascii as $key=>$item) {
                $acentos = '';
                foreach ($item AS $codigo) $acentos .= chr($codigo);
                $troca[$key] = '/['.$acentos.']/i';
            }
            $string = preg_replace(array_values($troca), array_keys($troca), $string);
            // Slug?
            if ($slug) {
                // Troca tudo que não for letra ou número por um caractere ($slug)
                $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
                // Tira os caracteres ($slug) repetidos
                $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
                $string = trim($string, $slug);
            }
            return $string;
        }

        public function transformacaoNomeMes($entrada) {
            switch ($entrada) {
                case "01": $entrada = 'janeiro';
                    break;
                case "02": $entrada = 'fevereiro';
                    break;
                case "03": $entrada = 'março';
                    break;
                case "04": $entrada = 'abril';
                    break;
                case "05": $entrada = 'maio';
                    break;
                case "06": $entrada = 'junho';
                    break;
                case "07": $entrada = 'julho';
                    break;
                case "08": $entrada = 'agosto';
                    break;
                case "09": $entrada = 'setembro';
                    break;
                case "10": $entrada = 'outubro';
                    break;
                case "11": $entrada = 'novembro';
                    break;
                case "12": $entrada = 'dezembro';
                    break;
            }

            return $entrada;
        }

        public function transformacaoSenha($entrada) {
            return crypt($entrada, '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
        }

        public function transformacaoSim($entrada) {
            return $entrada ? 'Sim' : 'Não';
        }

        public function transformacaoMonetario($entrada) {
            return number_format($entrada, 2, ',', '.');
        }

        public function transformacaoDecimal($entrada) {
            $entrada = str_replace('R$', '', $entrada);
            $entrada = str_replace('.', '', $entrada);
            $entrada = str_replace(',', '.', $entrada);
            return $entrada;
        }

        public function transformacaoNumeroExtenso($valor = 0, $maiusculas = false, $moeda = false) {
            $valor = str_replace('R$', '', $valor);
            // verifica se tem virgula decimal
            if (strpos($valor, ",") > 0) {
                // retira o ponto de milhar, se tiver
                $valor = str_replace(".", "", $valor);

                // troca a virgula decimal por ponto decimal
                $valor = str_replace(",", ".", $valor);
            }
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
                "quatrilhões");

            $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
                "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
            $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
                "sessenta", "setenta", "oitenta", "noventa");
            $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
                "dezesseis", "dezesete", "dezoito", "dezenove");
            $u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
                "sete", "oito", "nove");

            $z = 0;

            $valor = number_format($valor, 2, ".", ".");
            $inteiro = explode(".", $valor);
            $cont = count($inteiro);
            for ($i = 0; $i < $cont; $i++)
                for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                    $inteiro[$i] = "0" . $inteiro[$i];

            $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
            $rt = '';

            for ($i = 0; $i < $cont; $i++) {
                $valor = $inteiro[$i];
                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

                $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                        $ru) ? " e " : "") . $ru;
                $t = $cont - 1 - $i;
                if ($moeda)
                    $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")
                    $z++;
                elseif ($z > 0)
                    $z--;
                if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                    $r .= (($z > 1) ? " de " : "") . $plural[$t];
                if ($r)
                    $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                            ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
            }

            $rt = trim($rt);

            if (!$maiusculas) {
                return($rt ? $rt : "zero");
            } elseif ($maiusculas == "2") {
                return (strtoupper($rt) ? strtoupper($rt) : "Zero");
            } else {
                return (ucwords($rt) ? ucwords($rt) : "Zero");
            }
        }

        public function transformacaoTamanho($bytes, $modo) {
            $modo = strtolower($modo);
            switch ($modo) {
                case 'b':
                    break;

                case 'kb':
                    $bytes = number_format($bytes / 1024, 2);
                    break;

                case 'mb':
                    $bytes = number_format($bytes / 1048576, 2);
                    break;

                case 'gb':
                    $bytes = number_format($bytes / 1073741824, 2);
                    break;

                default:
                    if ($bytes >= 1073741824) {
                        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                    } elseif ($bytes >= 1048576) {
                        $bytes = number_format($bytes / 1048576, 2) . ' MB';
                    } elseif ($bytes >= 1024) {
                        $bytes = number_format($bytes / 1024, 2) . ' KB';
                    } elseif ($bytes > 1) {
                        $bytes = $bytes . ' bytes';
                    } elseif ($bytes == 1) {
                        $bytes = $bytes . ' byte';
                    } else {
                        $bytes = '0 bytes';
                    }
                    break;
            }
            return $bytes;
        }

        public function transformacaoOrcamentoForma($entrada) {
            $formas = array('aVista' => 'À vista',
                'parcelado' => 'Parcelado');
            return $formas[$entrada];
        }

        public function transformacaoOrcamentoVia($entrada) {
            $vias = array('boleto' => 'Boleto Bancário',
                'cartao' => 'Cartão de Crédito',
                'carne' => 'Carnê',
                'nota' => 'Nota Promissória',
                'dinheiro' => 'Dinheiro',
                'autorizacaoDesc' => 'Autorização de desconto',
                'mensalidade' => 'Mensalidade');
            return $vias[$entrada];
        }

        public function transformacaoTempoSegundo($entrada) {
            $entrada = explode(':', $entrada);
            if (!isset($entrada[1])) {
                $entrada = array(00, 00, 00);
            }
            $horas = $entrada[0];
            $minutos = $entrada[1];
            $segundos = isset($entrada[2]) ? $entrada[2] : 0;

            return ($horas * 3600) + ($minutos * 60) + $segundos;
        }

        public function transformacaoSegundoTempo($entrada) {
            $horas_seg = 3600;
            $horas = floor(($entrada / $horas_seg)); //resultado da hora
            $minutos = floor(($entrada - ($horas_seg * $horas)) / 60);
            $segundos = ($entrada - ($horas_seg * $horas) - ($minutos * 60));

            if ($horas < 10)
                $horas = '0' . $horas;

            if ($minutos < 10)
                $minutos = '0' . $minutos;

            if ($segundos < 10)
                $segundos = '0' . $segundos;

            return $horas . ':' . $minutos . ':' . $segundos;
        }

        public function transformacaoTipoDesconto($entrada) {
            $tipos = array(
                'prc' => 'Porcentagem',
                'qtd' => 'Dinheiro',
            );
            return $tipos[$entrada];
        }

        public function transformacaoPorcentagemDecimal($entrada){
            $entrada = str_replace('%', '', $entrada);
            $entrada = str_replace(',', '.', $entrada);
            return $entrada;
        }

        public function transformacaoDecimalPorcentagem($entrada){
            $entrada = str_replace('.', ',', $entrada);
            return $entrada;
        }

    }
    