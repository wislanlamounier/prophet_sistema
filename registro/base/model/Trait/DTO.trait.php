<?php
	trait DTO{

		/**
		 * Method used to get the data from
		 * a class
		 *
		 * @return Array - Data from a class in format array('atribute' => 'value');
		 *
		**/
	    public function getArrayData(){
	        $data = array();
	        foreach($this as $atribute => $value){
	        	if(!is_array($value))
	            	$data[$atribute] = $value;
	        }
	        return $data;
	    }

	    /**
	     * Method used to get the "getArrayData" ready for database use
	     *
	     * @param Array - data ready to be inserted on database
	     *
	    **/
	    public function getArrayDatabase($fields = array()){
	        $data = array();
	        foreach($this->getArrayData() as $atribute => $value){
	            if(!in_array($atribute, $fields)){
	            	if($atribute != 'password')
	                	$data[$atribute] = $value;
	                else
	                	if(trim($value) != '')
	                		$data[$atribute] = $value;
	            }
	        }
	        return $data;
	    }

	    /**
	     * Method used to check if a function needs parameters
	     *
	     * @param String $func - function name
	     * @return Boolean - true if needs, false if not
	     *
	    **/
		public function needParams($func) {
			$refl = new ReflectionMethod(get_class($this), $func);
			$numParams = $refl->getNumberOfParameters();
			return $numParams > 0;
		}

	    /**
	     * Method used to set a value to an attribute
	     *
	     * @param String $name - name of attribute
	     * @param String $value - value of attribute
	     * @return Boolean - true if success, false if not
	     *
	    **/
	    public function set($name, $value){
	    	if(property_exists($this, $name)){
    			if(isset($this->FieldsValidation[$name])){
		    		if($this->FieldsValidation[$name] != ''){
		    			$validation = $this->FieldsValidation[$name];
		    			if(is_array($validation)){
	    					$func = $validation[0];
	    					$table = $validation[1];
	    					if(!$this->{$func}($table, $value)){
	    						return false;
	    					}
		    			}else{
			    			if(count(explode(',', $validation)) > 0){
			    				$validation = explode(',', $validation);

			    				foreach($validation as $func){
			    					if(!$this->{$func}($value)){
			    						return false;
			    					}
			    				}
			    			}else{
			    				if(!$this->{$validation}($value)){
			    					return false;
			    				}
			    			}
		    			}
		    		}
		    	}
	    		$this->{$name} = $value;
				if($name != 'password'){
					if(isset($this->FieldsForm[$name])){
						if(!isset($this->FieldsForm[$name]['other']))
							$this->FieldsForm[$name]['other'] = array();
						$this->FieldsForm[$name]['other']['value'] = $value;
					}
				}
	    		return true;
	    	}
	    	return false;

	    }

	    /**
	     * Method used to return an attribute value
	     *
	     * @param String $name - attribute name
	     * @param Boolean $mask - use the dto's mask (optional)
	     * @return Mixed - attribute value
	     *
	    **/
	    public function get($name, $mask = null){
    		$value = $this->{$name};

    		if(isset($this->FieldsMasks[$name]) and !is_null($mask)){
    			$mask = $this->FieldsMasks[$name];
    			if(is_array($mask)){
    				$func = $mask[0];
    				$table = $mask[1];
    				$value = $this->{$func}($table, $value);
    			}else{
    				$value = $this->{$mask}($value);
    			}
    		}
    		return $value;
	    }
	}
