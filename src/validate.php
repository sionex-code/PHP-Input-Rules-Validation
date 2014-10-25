<?php
	/*
		Name: Validate Input Data [VID]
		Author: filereal
		Description: this is best simple example to check your filed at once.
		extend this class and add yor function return true and set custom errors 
	*/
	class InputRules {
			//Register globals
			public $curfiled;
			public $rules = array();
			public function addrules($array){
					$this->rules = $array;
			}
			//check each post and call the function 
			public function checkpost(){
				foreach ($this->rules as $f=>$r){
					$this->Err[$f] = ''; //this is used to prevent from empty index error
				}
				foreach ($this->rules as $f=>$r){
					
					if (isset($_POST[$f])){
						$explodedstr = explode('|',$r);
						foreach ($explodedstr as $t){
							$this->curfiled = $f;
							$this->$t($_POST[$f]);
						}
					}
				}
			}
			
			//Example Error Handler
			public $Err = array();
			public function Error($v,$t){
				$this->Err[$v] = $t;
				return $this->Err;
			}
			//Example Int Check Callback
			public function checkint($p){
				if (is_numeric($p)){
					$this->Error($this->curfiled,'passed');
					return true;
				}else{
					$this->Error($this->curfiled,'Int Check has been failed');
					return false;
				}				
			}
			//Example Email Check Callback
			function checkEmail($email) {
				if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
					$this->Error($this->curfiled,'passed');
					return true;
				}else{
					$this->Error($this->curfiled,'email validation failed.');
					return false;
				}
			}
			//Example Required Field Callback
			//don't combine this function with others ... need improvement....
			function required($c){
				if (!empty($c)){
					$this->Error($this->curfiled,'passed');
					return true;
				}else{
					$this->Error($this->curfiled,'Required Variable should not be empty');
					return false;
				}
			}
	}

	//Usage
	$rules = new InputRules(); // intance of this class
	//add new rules each function is saperated with | 
	
	$rules->addrules( 
		array(
			'email' => 'checkEmail',
			'age' => 'checkint'
		)
	);
	// if all rules passed do what ever you want if failed show error 
	if ($rules->checkpost()){
		//all data validated no tension
	}else{

		foreach ($rules->Err as $e=>$y){
			echo $e . ' => ' .$y.'<br />';
		}
		
	}
		
	
 
?>
<form action="" method="post">
	<input type="text" name="age" placeholder="age" /><?php echo $rules->Err['age']; ?><br />
	<input type="text" name="email" placeholder="email" /><br />
	<input type="submit"/>
</form>
