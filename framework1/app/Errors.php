<?php

	class Errors extends Controller {
		private $data = array();
		public static function notFound(){
			$text = 'Page not found, please check your address';
			die(self::load('errors/error', $text));
		}

		public static function permissionDenied(){
			$text = 'Ops, seems you cant access this page';
			die(self::load('errors/error', $text));
		}

		public static function cantAddRoute(){
			$text = "can't add the route for some reason";
			die(self::load('errors/error', $text));
		}

		public static function general(){
			$text = "oops seems something went wrong";
			die(self::load('errors/error', $text));
		}

		public static function cant_execute($function){
			$text = "can't execute " . $function . ' function. Missing argument';
			die(self::load('errors/error', $text));
		}
	}