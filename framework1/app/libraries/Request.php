
<?php
	class Request{
		public function __construct(){
			
		}

		public function post($index = null){
			if(is_null($index))
				return $_POST;
			else
				if(array_key_exists($index, $_POST))
					return $_POST[$index];
				else
					Error::code(701);
		}

		public function get($index = null){
			if(is_null($index))
				return $_GET;
			else
				if(array_key_exists($index, $_GET))
					return $_GET[$index];
				else
					Error::code(701);
		}
	}
	
?>
