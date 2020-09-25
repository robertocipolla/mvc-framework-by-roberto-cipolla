<?php
	class Pages extends Controller {
		public function __construct(){
			$this->postModel = $this->model("Post");
		}

		public function index(){
			$data = array();
			$data["text"] = "Welcome to home page";
			$this->load("Home", $data);
		}

		public function contact($name){
			die($name);
		}

		public function ciao(){

			Route::addParamsArr("wela/ciao/comestai", ["id" => 3]);
			$info = Route::info("wela/ciao/comestai");
			dd($info);
		}


	}