<?php
    /**
     * Class used for database operations
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.1 - 2015-06-10
     *
    **/
    class Model {

        private $debug;
        private $pdo;
        private $transaction = false;

        /**
         * Constructor method
         *
        **/
        public function __construct($debug = true, $database = _DATABASE, $user = _DATABASE_USER, $password = _DATABASE_PASSWORD, $host = _HOST) {
            $this->pdo = Connection::getConnection($debug, $database, $user, $password, $host);
        }

        /**
         * Method used for insert data in database
         *
         * @param String $table - table name
         * @param Object $data - DTO object to insert in database
         * @return Boolean - True if success, false if not.
         *
         **/
        public function insert($table, $data) {
            try{

                if (is_object($data))
                    $data = $data->getArrayDatabase();
                else
                    return false;

                $columns = array();

                foreach($data as $key => $value){
                    $columns[] = $key;
                    $values[] = ':'.$key;
                }

                $columnsStr = implode(', ', $columns);
                $dataStr = implode(', ', $values);

                $sql = "INSERT INTO ".$table." (".$columnsStr.") VALUES (".$dataStr.")";
                $query = $this->pdo->prepare($sql);

                foreach ($data as $key => $value)
                    $query->bindValue(':'.$key, $value);

                if($query->execute())
                  return true;
                else
                  return false;
            }
            catch (PDOException $e){
                $this->cancelTransaction();
                //if($this->debug)
                    echo _PDO_ERROR.$e->getMessage();
                return false;
            }
        }

        /**
         * Method used to update information in database
         *
         * @param String $table - table name
         * @param Object $data - DTO object of data
         * @param Array $condition - Array of conditions, example:
         *                          array('column1'    => 'data1',
         *                                'conscond1' => 'AND/OR',
         *                                'column2'   => 'data2',
         *                                'conscond2' => 'AND/OR',
         *                                'column3'   => 'data3);
         * @return Boolean - True if success, false if not.
         *
         **/
        public function update($table, $data, $condition) {

            try{
                $sql = "UPDATE ".$table." SET";

                if (is_object($data))
                    $data = $data->getArrayDatabase();
                else
                    return false;

                if(!is_array($condition))
                    return false;
                foreach($data as $column => $value){
                    $sql .= ' '.$column.' = :'.$column.',';
                }

                $sql = rtrim($sql, ',');

                $sql .= " WHERE ";
                
                foreach($condition as $column => $value){
                    if(strlen($column) > 8){
                        if(substr($column, 0, 8) == 'conscond'){
                            $sql .= ' '.$value.' ';
                        }else{
                            $sql .= $column.'=:'.$column.'Cond ';
                        }
                    }else{
                        $sql .= $column.'=:'.$column.'Cond ';
                    }
                }
                
                $query = $this->pdo->prepare($sql);

                foreach ($data as $key => $value)
                  $query->bindValue(':'.$key, $value);

                foreach($condition as $column => $value){
                    if(strlen($column) > 8){
                        if(substr($column, 0, 8) != 'conscond'){
                            $query->bindValue(':'.$column.'Cond', $value);
                        }
                    }else{
                        $query->bindValue(':'.$column.'Cond', $value);
                    }
                }

                return $query->execute();
            }catch(PDOException $e){
                $this->cancelTransaction();
                if($this->debug)
                    echo _PDO_ERROR.$e->getMessage();
                return false;
            }

        }

        /**
         * Method used to delete information in database
         *
         * @param String $table - table name
         * @param Array $condition - Array of conditions, example:
         *                          array('column1'    => 'data1',
         *                                'conscond1' => 'AND/OR',
         *                                'column2'   => 'data2',
         *                                'conscond2' => 'AND/OR',
         *                                'column3'   => 'data3);
         * @return Boolean - True if success, false if not.
         *
         **/
        public function delete($table, $condition) {
            try{
                $sql = 'DELETE FROM '.$table.' WHERE ';

                if(!is_array($condition))
                    return false;

                foreach($condition as $column=>$value){
                    if(strlen($column) > 8){
                        if(substr($column, 0, 8) == 'conscond'){
                            $sql .= ' '.$value.' ';
                        }else{
                            $sql .= $column.'=:'.$column.'Cond ';
                        }
                    }else{
                        $sql .= $column.'=:'.$column.'Cond ';
                    }
                }

                $query = $this->pdo->prepare($sql);


                foreach($condition as $column=>$value){
                    if(strlen($column) > 8){
                        if(substr($column, 0, 8) != 'conscond'){
                            $query->bindValue(':'.$column.'Cond', $value);
                        }
                    }else{
                        $query->bindValue(':'.$column.'Cond', $value);
                    }
                }

                return $query->execute();
            } catch(PDOException $e){
                $this->cancelTransaction();
                if($this->debug)
                    echo _PDO_ERROR.$e->getMessage();
                return false;
            }
        }

        /**
         * Method used to search information in database
         *
         * @param String $table - table name
         * @param String $columns - list of columns separated by comma - 'column1, column2...'. Default: *
         * @param Array $condition - Array of conditions. Default: false. Example:
         *                          array('column1'    => 'data1',
         *                                'conscond1' => 'AND/OR',
         *                                'column2'   => 'data2',
         *                                'conscond2' => 'AND/OR',
         *                                'column3'   => 'data3);
         * @param String $order - list of columns to order by separated by comma. Default: false.
         * @param String $group - column to group by. Default: false.
         * @param String $limit - limit of results. Default: false.
         * @return Boolean - True if success, false if not.
         *
         **/
        public function search($table, $columns = '*', $condition = false, $order = false, $group = false, $limit = false) {
            try{
                if (is_array($columns)) {
                    $columns = implode(', ', $columns);
                }

                if(!is_array($condition)){
                    if($condition != false){
                        return false;
                    }
                }

                $sql = "SELECT ".$columns." FROM ".$table;

                if ($condition != false){
                    $sql .= ' WHERE ';
                    foreach($condition as $column=>$value){

                        if(strlen($column) > 8){
                            if(substr($column, 0, 8) == 'conscond'){
                                $sql .= ' '.$value.' ';
                            }else{
                                $sql .= $column.'=:'.$column.' ';
                            }
                        }else{
                            $sql .= $column.'=:'.$column.' ';
                        }
                    }
                }




                if ($order != false)
                    $sql .= " ORDER BY ".$order;

                if($group != false)
                    $sql .= ' GROUP BY '.$group;

                if ($limit != false)
                    $sql .= " LIMIT ".$limit;


                $query = $this->pdo->prepare($sql);

                if($condition != false){
                    foreach($condition as $column=>$value){
                        if(strlen($column) > 8){
                            if(substr($column, 0, 8) != 'conscond'){
                                $query->bindValue(':'.$column, $value);
                            }
                        }else{
                            $query->bindValue(':'.$column, $value);
                        }
                    }
                }
                
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }catch(PDOException $e){
                $this->cancelTransaction();
                if($this->debug)
                    echo _PDO_ERROR.$e->getMessage();
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
            try{
                $query = $this->pdo->prepare($sql);
                return $query->execute();
            }
            catch(PDOException $e){
                $this->cancelTransaction();
                if($this->debug)
                    echo _PDO_ERROR.$e->getMessage();
                return false;
            }
        }

        /**
         * Method used to count a num of rows in a table
         *
         * @param String $table - table name
         * @param Array $condition - Array of conditions. Default: false. Example:
         *                           array('column1'    => 'data1',
         *                                'conscond1' => 'AND/OR',
         *                                'column2'   => 'data2',
         *                                'conscond2' => 'AND/OR',
         *                                'column3'   => 'data3);
         * @return Integer - number of rows
         *
        **/
        public function numRows($table, $condition = false){
            if(!is_array($condition)){
                if($condition != false){
                    return false;
                }
            }
            $query = $this->search($table, '*', $condition);
            return count($query);
        }

        /**
         * Method used to return the last inserted register in a table
         *
         * @param String $table - table name
         * @return Mixed - ID of last result if success, false if not.
         *
        **/
        public function lastInserted($table){
            try {
                return $this->pdo->lastInsertId($table);
            }catch (PDOException $ex) {
                $this->cancelTransaction();
                if($this->debug)
                   echo _PDO_ERROR.$e->getMessage();
                  return false;
            }
        }

		/**
		 * Method used to check if an register exists
		 *
		 * @param String $table - table name
		 * @param String $key - key of the table to be used in the query.
		 * @param String $value - value to be searched.
		 * @return Boolean - True if exists, false if not.
		 *
	 	**/
		public function exists($table, $key, $value){
			$query = $this->search($table, '*', array($key => $value));
			return (is_array($query) and count($query) > 0);
		}

        /**
         * Method used to init a transaction
         *
        **/
        public function initTransaction(){
            $this->pdo->beginTransaction();
            $this->transaction = true;
        }

        /**
         * Method used to end a transaction
         *
        **/
        public function endTransaction(){
            $this->pdo->commit();
            $this->transaction = false;
        }

        /**
         * Method used to rollback a transaction
         *
        **/
        public function cancelTransaction(){
            if($this->transaction){
                $this->pdo->rollback();
                $this->transaction = false;
            }
        }

        /**
         * Method used to get a DTO
         *
         * @param String $table - table name
         * @param String $primary - primary key
         * @param Integer $id - key value
         * @param Array $data - register from database (optional)
         * @return Object - DTO object
         *
        **/
        public function getDto($table, $primary, $id, $data = null){
            eval('$dto = new '.ucfirst($table).'();');
            if($table == 'user')
                $table = 'usuario';
            if($table == 'clinic')
                $table = 'clinica';
            if(is_null($data)){
                if($this->exists($table, $primary, $id)){
                    $data = $this->search($table, '*', array($primary => $id))[0];
                }
            }
            if(is_array($data)){
                foreach($dto->getArrayDatabase() as $field => $value){
                    $dto->set($field, $data[$field]);
                }
            }
            return $dto;
        }

        /** 
         * Method used to transform a query array to a dto array
         *
         * @param Array $query - registers from database
         * @param String $table - table name
         * @return Array - array of dtos
         *
        **/
        public function query2dto($query, $table){
            $dtos = array();
            foreach($query as $register){
                $dto = $this->getDto($table, '', '', $register);
                $dtos[] = $dto;
            }
            return $dtos;
        }
    }

?>
