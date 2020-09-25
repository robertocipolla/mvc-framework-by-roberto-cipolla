<?php
	 function dd($argument = null){
		if(!is_null($argument)){
			die(var_dump($argument));
		}else{
			Errors::cant_execute("dd");
		}
	}

	function dump($argument = null){
		if(!is_null($argument)){
			var_dump($argument);
		}else{
			Errors::cant_execute("dump");
		}
	}