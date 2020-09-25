<?php
	 function server($attr){
		$server = array();
		$server = $GLOBALS["server"];

		if(array_key_exists($attr, $server)){
			return $server[$attr];
		}else{
			return false;
		}
	}

	function post($attr = null){

		$post = array();
		$post = $GLOBALS["post"];
		if(!is_null($attr)){
			if(array_key_exists($attr, $post)){
				return $post[$attr];
			}else{
				return false;
			}
		}else{
			return $post;
		}
	}