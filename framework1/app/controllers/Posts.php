<?php
	class Posts extends Controller {

		public function __construct(){
			$this->postModel = $this->model("Post");
		}

		public function showCreatePage($data = []){
			$info = Route::info("create/post");
			if($info["request"] == server("method")){

				$this->load('create');

			}else{
				die("kl");
			}
		}

		public function store(){
			$info = Route::info("create/post");

			$data = $this->extract(post());

			$rules = [
				"title" => ["required", "text", "3", 10 ],
				"body" => ["not_required", "text", "10", "20"],
				"author" => []
			];

			$validatedData = $this->validate($data, $rules);
			// dd($validatedData);
			if(!is_array($validatedData)){
				$row = $this->postModel->create($data);

				if($row){
					redirect("");
				}else{
					Errors::general();
				}
			}else{
				$data = $this->setDataErrors($data, $validatedData);
				$this->load("create", $data);
				// redirect("create/post");
			}



		}

	}