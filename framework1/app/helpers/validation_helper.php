<?php
	function rules($type){
		$types = [
			"register" => [
				"name" => ["required", "text", 3, 25],
				"email" => ["required", "email"],
				"password" => ["required", "text", 6, 100],
				"confirm_password" => ["required", "confirm_password"]
			],
			"login" => [
				"email" => ["required", "email"],
				"password" => ["required", "text", 6, 100]
			]
		];

		if(array_key_exists($type, $types)){
			return $types[$type];
		}else{
			return false;
		}

	}