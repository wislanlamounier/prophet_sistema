<?php
    /**
     * Classe que realiza as operações
     * envolvendo banco de dados.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.1 - 2015-06-10
     *
    **/
    class Modelo {

        private $debug;
        private $pdo;

        /**
         * Método construtor da classe
         *
         * @param Boolean $main - True para conectar ao banco main, false para o da clinica
         * @param Boolean $debug - True para ativar debug e false para desativar
         * @param String $banco - Nome do banco de dados
         * @param String $usuario - Usuario do banco de dados
         * @param String $senha - Senha do banco de dados
        **/
        public function __construct($main = false, $debug = true, $banco = BANCO, $usuario = USUARIO_BANCO, $senha = SENHA_BANCO) {
            $this->debug = $debug;

            if($main){
                $banco = 'prophet_main';
                if($_SERVER['HTTP_HOST'] == 'localhost:8083'){
                    $usuario = 'root';
                    $senha = '';
                }else{
                    $usuario = 'root';
                    $senha = 'bentonet2412';
                }
            }

            try {
                $this->pdo = new PDO('mysql:host=' .HOST . ';dbname=' .$banco,
                					 $usuario,
                					 $senha,
                					 array(PDO::ATTR_PERSISTENT => true));
                if($debug){
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                }
                $this->pdo->query("SET NAMES 'utf8'");
                $this->pdo->query('SET character_set_connection=utf8');
                $this->pdo->query('SET character_set_client=utf8');
                $this->pdo->query('SET character_set_results=utf8');
            } catch (PDOException $e) {
                if($this->debug)
                    echo "Ocorreu um erro de conexão: " . $e->getMessage();
            }
        }

        /**
         * Método destrutor da classe
         *
        **/
        public function __destruct(){
            $this->pdo = null;
        }

        /**
         * Método utilizado para inserir informações
         * no banco de dados.
         *
         * @param String $tabela - tabela para inserir os dados
         * @param Object/Array $dados - Array ou objeto DTO para inserir os dados
         * @return Boolean - True se a transação ocorreu corretamente se não false.
         *
         **/
        public function inserir($tabela, $dados) {
            try{
                if (is_object($dados)) {
                    $dados = $dados->getArrayDados();
                }
                else if(!is_array($dados)){
                    return false;
                }
                $colunas = $valores = array();
                foreach ($dados as $key => $value) {
                    $colunas[] = $key;
                    $valores[] = $value;
                    $values[] = ':'.$key;
                }
                $colunasStr = implode(', ', $colunas);
                $dadosStr = implode(', ', $values);
                $sql = "INSERT INTO ".$tabela." (".$colunasStr.") VALUES (".$dadosStr.")";

                $sql = $this->pdo->prepare($sql);
                foreach ($dados as $key => $value) {
                    $sql->bindValue(':'.$key, $value);
                }
                return $sql->execute();
            } catch (PDOException $e){
                if($this->debug)
                    echo "Ocorreu um erro: " . $e->getMessage();
                return false;
            }
        }

        /**
         * Método utilizado para atualizar informações
         * no banco de dados.
         *
         * @param String $tabela - tabela para atualizar os dados
         * @param Object/Array $dados - Array ou objeto DTO para atualizar os dados
         * @param Array $condicao - Array de condicoes para utilizar. Modelo de exemplo:
         *                          array('coluna'    => 'dadoColuna',
         *                                'conscond1' => 'AND/OR',
         *                                'coluna2'   => 'dadoColuna2',
         *                                'conscond2' => 'AND/OR',
         *                                'coluna3'   => 'dadoColuna);
         * @return Boolean - True se a transação ocorreu corretamente se não false.
         *
         **/

        public function atualizar($tabela, $dados, $condicao) {
            try{
                $sql = "UPDATE ".$tabela." SET";

                if(!is_array($dados)){
                    if(!is_object($dados))
                        return false;
                    else
                        $dados = $dados->getArrayDados();
                }
                if(!is_array($condicao))
                    return false;

                foreach($dados as $coluna=>$valor){
                    $sql .= ' '.$coluna.' = :'.$coluna.',';
                }

                $sql = rtrim($sql, ',');

                $sql .= " WHERE ";
                foreach($condicao as $coluna=>$valor){
                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) == 'conscond'){
                            $sql .= ' '.$valor.' ';
                        }else{
                            $sql .= $coluna.'=:'.$coluna.'Cond ';
                        }
                    }else{
                        $sql .= $coluna.'=:'.$coluna.'Cond ';
                    }
                }

                $sql = $this->pdo->prepare($sql);

                foreach($dados as $coluna=>$valor){
                    $sql->bindValue(':'.$coluna, $valor);
                }
                foreach($condicao as $coluna=>$valor){
                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) != 'conscond'){
                            $sql->bindValue(':'.$coluna.'Cond', $valor);
                        }
                    }else{
                        $sql->bindValue(':'.$coluna.'Cond', $valor);
                    }
                }
                return $sql->execute() === true;
            } catch(PDOException $e){
                if($this->debug)
                    echo "Ocorreu um erro: " . $e->getMessage();
                return false;
            }

        }

        /**
         * Método utilizado para deletar informações
         * no banco de dados.
         *
         * @param String $tabela - tabela para deletar os dados
         * @param Array $condicao - Array de condicoes para utilizar. Modelo de exemplo:
         *                          array('coluna'    => 'dadoColuna',
         *                                'conscond1' => 'AND/OR',
         *                                'coluna2'   => 'dadoColuna2',
         *                                'conscond2' => 'AND/OR',
         *                                'coluna3'   => 'dadoColuna);
         * @return Boolean - True se a transação ocorreu corretamente se não false.
         *
         **/
        public function deletar($tabela, $condicao) {
            try{
                $sql = 'DELETE FROM '.$tabela.' WHERE ';

                if(!is_array($condicao))
                    return false;

                foreach($condicao as $coluna=>$valor){
                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) == 'conscond'){
                            $sql .= ' '.$valor.' ';
                        }else{
                            $sql .= $coluna.'=:'.$coluna.'Cond ';
                        }
                    }else{
                        $sql .= $coluna.'=:'.$coluna.'Cond ';
                    }
                }

                $sql = $this->pdo->prepare($sql);


                foreach($condicao as $coluna=>$valor){
                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) != 'conscond'){
                            $sql->bindValue(':'.$coluna.'Cond', $valor);
                        }
                    }else{
                        $sql->bindValue(':'.$coluna.'Cond', $valor);
                    }
                }

                return $sql->execute();
            } catch(PDOException $e){
                if($this->debug)
                    echo "Ocorreu um erro: " . $e->getMessage();
                return false;
            }
        }

        /**
         * Método utilizado para consultar informações
         * no banco de dados.
         *
         * @param String $tabela - tabela para deletar os dados
         * @param String $colunas - colunas para retornar as informações. Formato SQL. (col,col2...)
         * @param Array $condicao - Array de condicoes para utilizar. Modelo de exemplo:
         *                          array('coluna'    => 'dadoColuna',
         *                                'conscond1' => 'AND/OR',
         *                                'coluna2'   => 'dadoColuna2',
         *                                'conscond2' => 'AND/OR',
         *                                'coluna3'   => 'dadoColuna);
         * @param String $ordenacao - Coluna para ordenar
         * @param String $limite - Limite de resultados
         * @return Array - Array de objetos do banco
         *
         **/
        public function consultar($tabela, $colunas = '*', $condicao = false, $ordenacao = false, $limite = false, $group = false) {
            if (is_array($colunas)) {
                $colunas = implode(', ', $colunas);
            }

            if(!is_array($condicao)){
                if($condicao != false){
                    return false;
                }
            }

            $sql = "SELECT ".$colunas." FROM ".$tabela;

            if ($condicao != false){
                $sql .= ' WHERE ';
                foreach($condicao as $coluna=>$valor){

                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) == 'conscond'){
                            $sql .= ' '.$valor.' ';
                        }else{
                            $sql .= $coluna.'=:'.$coluna.' ';
                        }
                    }else{
                        $sql .= $coluna.'=:'.$coluna.' ';
                    }
                }
            }




            if ($ordenacao != false)
                $sql .= " ORDER BY ".$ordenacao;

            if ($limite != false)
                $sql .= " LIMIT ".$limite;

            if($group != false)
                $sql .= " GROUP BY ".$group;

            $sql = $this->pdo->prepare($sql);
            if($condicao != false){
                foreach($condicao as $coluna=>$valor){
                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) != 'conscond'){
                            $sql->bindValue(':'.$coluna, $valor);
                        }
                    }else{
                        $sql->bindValue(':'.$coluna, $valor);
                    }
                }
            }

            try {
                $sql->execute();
                $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $ex) {
                return false;
            }

        }

        /**
         * Método utilizado para realizar um query livre no banco de dados.
         * Devido a questões de segurança, deve ser utilizado apenas
         * quando não é possível a entrada de dados a partir de usuários.
         *
         * @param String $sql - query
         * @return Array - resultado do query no banco
        **/

        public function query($sql) {
            $sql = $this->pdo->prepare($sql);
            $query = $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        }

        /**
         * Método utilizado para realizar um SQL livre no banco de dados.
         * Devido a questões de segurança, deve ser utilizado apenas
         * quando não é possível a entrada de dados a partir de usuários.
         *
         * @param String $sql - sql
        **/

        public function sql($sql) {
            $sql = $this->pdo->prepare($sql);
            $query = $sql->execute();
        }

        /**
         * Método responsável por retornar o último inserido de uma tabela
         *
         * @param String $tabela - nome da tabela
         * @return Integer - id do último registro da tabela
         *
        **/
        public function ultimoInserido($tabela){
            $sql = 'SHOW KEYS FROM '.$tabela.' WHERE Key_name = "PRIMARY"';
            $consulta = $this->query($sql);
            if(is_array($consulta) and count($consulta)){
                $primaria = $consulta[0]['Column_name'];
                $query = $this->query('SELECT '.$primaria.' FROM '.$tabela.' ORDER BY '.$primaria.' DESC limit 1');
                if(count($query) == 0)
                    return 0;
                return $query[0][$primaria];
            }else{
                return 0;
            }
        }

		/**
		 * Método utilizado para realizar a checagem de existencia
		 * de algum registro no banco.
		 *
		 * @param String $tabela - nome da tabela do banco.
		 * @param String $chave - chave que será utilizada na busca.
		 * @param String $valor - valor a ser pesquisado.
		 * @return Boolean - true se encontrou, false se não.
		 *
	 	**/
		public function checaExiste($tabela, $chave, $valor){

			$consulta = $this->consultar($tabela, '*', array($chave => $valor));
			if(is_array($consulta) and count($consulta) > 0){
				return true;
			}else{
				return false;
			}
		}

		/**
		 * Método responsável por contar o número de registros de uma tabela
		 *
		 * @param String $tabela - nome da tabela
		 * @param Array $condicao - array de condicao
		 * @return Integer - número de registros
		 *
		**/
		public function contar($tabela, $condicao = false){
			$sql = 'SELECT COUNT(*) as cont FROM '.$tabela;
            if($condicao != false){
                $sql .= ' WHERE ';
                foreach($condicao as $coluna=>$valor){

                    if(strlen($coluna) > 8){
                        if(substr($coluna, 0, 8) == 'conscond'){
                            $sql .= ' '.$valor.' ';
                        }else{
                            $sql .= $coluna.'='.$valor.' ';
                        }
                    }else{
                        $sql .= $coluna.'='.$valor.' ';
                    }
                }
            }
            return $this->query($sql)[0]['cont'];
		}

        /**
         * Método responsável por buscar um registro no banco e retornar seu
         * respectivo DTO.
         *
         * @param String $nomTabela - nome da tabela
         * @param String $nomPrimaria - nome da chave primária
         * @param Integer $cdnRegistro - código numérico do registro
         * @return Object - objeto DTO do registro
         *
        **/
        public function getRegistro($nomTabela, $nomPrimaria, $cdnRegistro){
            if(class_exists(ucfirst($nomTabela))){
                eval('$dtoRegistro = new '.ucfirst($nomTabela).'();');
            }else{
                if($nomTabela == 'usuario_master')
                    $dtoRegistro = new DTOUsuario();
                else
                    eval('$dtoRegistro = new DTO'.ucfirst($nomTabela).'();');
            }

            if($this->checaExiste($nomTabela, $nomPrimaria, $cdnRegistro)){
                $arrRegistro = $this->consultar($nomTabela, '*', array($nomPrimaria => $cdnRegistro))[0];
                foreach($dtoRegistro->getArrayDados() as $nomCampo => $valCampo){
                    $nomFuncao = 'set'.ucfirst($nomCampo);
                    $dtoRegistro->{$nomFuncao}($arrRegistro[$nomCampo]);
                }
            }
            return $dtoRegistro;
        }

        /**
         * Método responsável por identificar se o usuário atual é um usuário master
         *
         * @return Boolean - true se é, false se não
         *
        **/
        public function master(){
            if(isset($_SESSION['master'])){
                if($this->checaExiste('usuario_master', 'cdnUsuario', $_SESSION['cdnUsuario']))
                    return true;
            }
            return false;
        }

        /**
         * Método responsável por identificar se o usuário atual é um usuário master
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se é, false se não
         *
        **/
        static function masterStatic($cdnUsuario){
            $modelo = new Modelo();
            if($modelo->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario))
                return true;
        }

        /**
         * Método responsável por retornar o tipo de usuário atual do sistema
         *
         * @param Integer $cdnUsuario - código numérico do usuário. Padrão: $_SESSION['cdnUuario']
         * @return String - master, colaborador ou dentista.
         *
        **/
        public function usuarioAtual($cdnUsuario = null){

            if(isset($_SESSION['cdnUsuario'])){
                if(is_null($cdnUsuario))
                    $cdnUsuario = $_SESSION['cdnUsuario'];
            }


            if($this->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario))
                return 'master';

            if($this->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario))
                return 'colaborador';

            if($this->checaExiste('dentista', 'cdnUsuario', $cdnUsuario))
                return 'dentista';

            return null;
        }

        /**
         * Mètodo responsável por verificar se o usuário é o dono da clínica
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se é, false se não
         *
        **/
        public function dono($cdnUsuario = 0){
            if($cdnUsuario == 0){
                if(isset($_SESSION['cdnUsuario']))
                    $cdnUsuario = $_SESSION['cdnUsuario'];
                else
                    return false;
            }

            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
            return $dtoClinica->getCdnUsuario() == $cdnUsuario;

        }

        /**
         * Método responsável por verificar se o usuário é o dono da clínica
         *
         * @param Integer $cdnUsuário - código numérico da clínica
         * @return Boolean - true se é, false se não
         *
        **/
        static function donoStatic($cdnUsuario = 0){
            $modelo = new Modelo();
            return $modelo->dono($cdnUsuario);
        }

        static function colaborador($cdnUsuario){
            $modelo = new Modelo(false, true, 'prophet_'.$_SESSION['nomBanco']);
            return $modelo->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario);
        }

        static function dentista($cdnUsuario){
            $modelo = new Modelo(false, true, 'prophet_'.$_SESSION['nomBanco']);
            return $modelo->checaExiste('dentista', 'cdnUsuario', $cdnUsuario);
        }
    }

    ?>
