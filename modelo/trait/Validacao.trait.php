<?php

    trait Validacao {

        public function validacaoNumero($entrada) {
            return filter_var($entrada, FILTER_VALIDATE_INT) or filter_var($entrada, FILTER_VALIDATE_FLOAT) or $entrada == 0;
        }

        public function validacaoEmail($entrada) {
            return filter_var($entrada, FILTER_VALIDATE_EMAIL);
        }

        public function validacaoEspeciais($entrada) {
            return htmlspecialchars($entrada) == $entrada;
        }

        public function validacaoBooleano($entrada) {
            return true;
        }

        public function validacaoCpf($entrada) {

            $entrada = ereg_replace('[^0-9]', '', $entrada);
            $entrada = str_pad($entrada, 11, '0', STR_PAD_LEFT);


            if (strlen($entrada) != 11) {
                return false;
            } else {

                for ($t = 9; $t < 11; $t++) {

                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $entrada{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($entrada{$c} != $d) {
                        return false;
                    }
                }
                return true;
            }
        }

        public function validacaoData($entrada) {
            $old = $entrada;
            $entrada = explode('-', $entrada);
            if (count($entrada) == 3) {
                $entrada[0] = ltrim($entrada[0], 0);
                $entrada[1] = ltrim($entrada[1], 0);
                $entrada[2] = ltrim($entrada[2], 0);
                if (filter_var($entrada[0], FILTER_VALIDATE_INT) and
                        filter_var($entrada[1], FILTER_VALIDATE_INT) and
                        filter_var($entrada[2], FILTER_VALIDATE_INT)) {
                    if (checkdate($entrada[1], $entrada[2], $entrada[0])) {
                        return true;
                    }
                }
            }

            return false;
        }

        public function validacaoDataPassou($entrada) {
            if ($this->validacaoData($entrada)) {
                $entrada = explode('-', $entrada);
                if (count($entrada) == 3) {

                    if (checkdate($entrada[1], $entrada[2], $entrada[0])) {
                        return strtotime(implode('-', $entrada)) > strtotime(date('Y-m-d'));
                    }
                }
                return false;
            }
            return false;
        }

        public function validacaoHorario($entrada) {
            $entrada = explode(':', $entrada);
            if (count($entrada) == 2) {
                if (($entrada[0] < 24) && ($entrada[1] < 60)) {
                    return true;
                }
            } elseif (count($entrada) == 3) {
                if (($entrada[0] < 24) && ($entrada[1] < 60) && ($entrada[2] < 60)) {
                    return true;
                }
            }
        }

        public function validacaoIntervaloHorario($entrada) {
            $entrada = explode('-', $entrada);
            if (count($entrada) == 2) {
                if (!$this->validacaoHorario($entrada[0]))
                    return false;
                if (!$this->validacaoHorario($entrada[1]))
                    return false;
                return true;
            }
            return false;
        }

        public function validacaoDatetime($entrada) {
            $entrada = explode(' ', $entrada);
            if (count($entrada) != 2)
                return false;
            if (!$this->validacaoData($entrada[0]))
                return false;
            if (!$this->validacaoHorario($entrada[1]))
                return false;
            return true;
        }

        public function validacaoUf($entrada) {
            $entrada = strtoupper($entrada);
            $arrUF = array("AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraíba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RS" => "Rio Grande do Sul", "RR" => "Roraima", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");

            return array_key_exists($entrada, $arrUF);
        }

        public function validacaoPorcentagem($entrada, $minimo, $maximo) {
            if (filter_var($entrada, FILTER_VALIDATE_INT) || filter_var($entrada, FILTER_VALIDATE_FLOAT)) {
                if (($entrada >= $minimo) && ($entrada <= $maximo))
                    return true;
            }
            return false;
        }

        public function validacaoCnpj($entrada) {
            $j = 0;
            for ($i = 0; $i < (strlen($entrada)); $i++) {
                if (is_numeric($entrada[$i])) {
                    $num[$j] = $entrada[$i];
                    $j++;
                }
            }
            if (!isset($num)) {
                $isCnpjValid = false;
            } else {
                //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
                if (count($num) != 14) {
                    return false;
                }

                //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
                if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0) {
                    $isCnpjValid = false;
                }
                //Etapa 4: Calcula e compara o primeiro dígito verificador.
                else {
                    $j = 5;
                    for ($i = 0; $i < 4; $i++) {
                        $multiplica[$i] = $num[$i] * $j;
                        $j--;
                    }
                    $soma = array_sum($multiplica);
                    $j = 9;
                    for ($i = 4; $i < 12; $i++) {
                        $multiplica[$i] = $num[$i] * $j;
                        $j--;
                    }
                    $soma = array_sum($multiplica);
                    $resto = $soma % 11;
                    if ($resto < 2) {
                        $dg = 0;
                    } else {
                        $dg = 11 - $resto;
                    }
                    if ($dg != $num[12]) {
                        $isCnpjValid = false;
                    }
                }
                //Etapa 5: Calcula e compara o segundo dígito verificador.
                if (!isset($isCnpjValid)) {
                    $j = 6;
                    for ($i = 0; $i < 5; $i++) {
                        $multiplica[$i] = $num[$i] * $j;
                        $j--;
                    }
                    $soma = array_sum($multiplica);
                    $j = 9;
                    for ($i = 5; $i < 13; $i++) {
                        $multiplica[$i] = $num[$i] * $j;
                        $j--;
                    }
                    $soma = array_sum($multiplica);
                    $resto = $soma % 11;
                    if ($resto < 2) {
                        $dg = 0;
                    } else {
                        $dg = 11 - $resto;
                    }
                    if ($dg != $num[13]) {
                        $isCnpjValid = false;
                    } else {
                        $isCnpjValid = true;
                    }
                }
            }
            return $isCnpjValid;
        }

        public function validacaoCpfCnpj($entrada) {
            if (!$this->validacaoCpf($entrada)) {
                if (!$this->validacaoCnpj($entrada)) {
                    return false;
                }
            }
            return true;
        }

        public function validacaoArquivo($entrada, $arrTipo) {
            $extensao = explode('.', $entrada);
            if (count($extensao) < 2)
                return false;
            $extensao = strtolower($extensao[count($extensao) - 1]);
            if (!is_array($arrTipo))
                $arrTipo = array($arrTipo);

            foreach ($arrTipo as $tipo) {
                if ($tipo == 'imagem') {
                    $mime = array('image/gif' => 'gif',
                        'image/jpeg' => 'jpeg',
                        'image/jpg' => 'jpg',
                        'image/png' => 'png',
                        'application/x-shockwave-flash' => 'swf',
                        'image/psd' => 'psd',
                        'image/bmp' => 'bmp',
                        'image/tiff' => 'tiff',
                        'image/tiff' => 'tiff',
                        'image/jp2' => 'jp2',
                        'image/iff' => 'iff',
                        'image/vnd.wap.wbmp' => 'bmp',
                        'image/xbm' => 'xbm',
                        'image/vnd.microsoft.icon' => 'ico');
                    if (in_array($extensao, $mime))
                        return true;
                }
                if ($tipo == 'pdf')
                    if ($extensao == 'pdf')
                        return true;
            }
            return false;
        }

        public function validacaoImagem($entrada) {
            return $this->validacaoArquivo($entrada, 'imagem');
        }

        public function validacaoDecimal($entrada) {
            return is_numeric($entrada);
        }

        public function validacaoVazio($entrada) {
            return trim($entrada) != '';
        }

        public function validacaoPaciente($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('paciente', 'cdnPaciente', $entrada);
            }
            return true;
        }

        public function validacaoAreaAtuacao($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('areaatuacao', 'cdnAreaAtuacao', $entrada);
            }
            return true;
        }

        public function validacaoProcedimento($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('procedimento', 'cdnProcedimento', $entrada);
            }
            return true;
        }

        public function validacaoSecao($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('secao', 'cdnSecao', $entrada);
            }
            return true;
        }

        public function validacaoDentista($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('dentista', 'cdnUsuario', $entrada);
            }
            return true;
        }

        public function validacaoConsultorio($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('consultorio', 'cdnConsultorio', $entrada);
            }
            return true;
        }

        public function validacaoOrcamento($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('orcamento', 'cdnOrcamento', $entrada);
            }
            return true;
        }

        public function validacaoParceria($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('parceria', 'cdnParceria', $entrada);
            }
            return true;
        }

        public function validacaoOrcamentoForma($entrada) {
            $formas = array('aVista', 'parcelado');
            return in_array($entrada, $formas);
        }

        public function validacaoOrcamentoVia($entrada) {
            $vias = array('boleto', 'cartao', 'carne', 'nota', 'dinheiro', 'autorizacaoDesc', 'mensalidade');
            return in_array($entrada, $vias);
        }

        public function validacaoConsulta($entrada) {
            if (BANCO != 'prophet_main') {
                $modelo = new Modelo();
                return $modelo->checaExiste('consulta', 'cdnConsulta', $entrada);
            }
            return true;
        }

        public function validacaoPalavrasChave($entrada, $tipo) {
            $palavras = array(
                'consulta' => array(
                    '%paciente%',
                    '%pacienteCompleto%',
                    '%horario%',
                    '%dataConsulta%',
                    '%clinica%',
                    '%profissional%',
                    '%data%',
                ),
                'pesquisa' => array(
                    '%paciente%',
                    '%pacienteCompleto%',
                    '%profissional%',
                    '%data%',
                ),
                'dataFestiva' => array(
                    '%paciente%',
                    '%pacienteCompleto%',
                    '%clinica%',
                    '%dataFestiva%',
                    '%data%',
                ),
                'aniversario' => array(
                    '%paciente%',
                    '%pacienteCompleto%',
                    '%clinica%',
                    '%data%',
                ),
            );
            $entrada = explode(' ', $entrada);
            foreach ($entrada as $palavra) {
                if (strlen($palavra) < 3)
                    continue;
                if ($palavra[0] == '%') {
                    $posicao = strpos($palavra, '%', 1);
                    if ($posicao !== 0) {
                        $palavra = substr($palavra, 0, $posicao + 1);
                        if(!in_array($palavra, $palavras[$tipo])){
                            return false;
                        }
                    }
                }
            }
            return true;
        }

    }
    