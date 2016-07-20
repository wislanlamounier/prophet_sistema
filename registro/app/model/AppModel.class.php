<?php

	class AppModel extends Model{
		private $caller;

		public function __construct(){
			parent::__construct();
			$this->caller = debug_backtrace()[2]['object'];
		}

		public function caller(){
			return $this->caller;
		}

		public function makeDto($dto, $id = null){
			$data = $dto->getArrayData();
			$errors = '';
			
			foreach($data as $field => $value){
				if($field != 'id'){
					if(!isset($_POST[$field]))
						$_POST[$field] = '';

					if(!$dto->set($field, $_POST[$field])){
						$errors .= $dto->FieldsErrors[$field].'<br>';
					}
				}
			}

			if(!is_null($id))
				$dto->set('id', $id);

			return array($dto, $errors);
		}
	}
