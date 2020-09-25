<?php
	class Superglobals {
		public function __construct(){
			$server = array();
			$server["method"] = $_SERVER["REQUEST_METHOD"];
			$server["url"] = $_SERVER["QUERY_STRING"];
			$GLOBALS["server"] = $server;

			$post = array();

			$post = array_merge($_POST, $post);
			$GLOBALS["post"] = $post;

		}
	}