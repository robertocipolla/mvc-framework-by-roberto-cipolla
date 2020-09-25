<?php
	class Controller {


		public function model($model){
			require_once '../app/models/' . $model . '.php';

			// instantiate the model
			return new $model();
		}

		public function load($page, $data = []){
			$footer = file_get_contents('../app/inc/footer.php');
			$header = file_get_contents('../app/inc/header.php');
			foreach(array_keys($data) as $dataKey){
				${$dataKey} = $data[$dataKey];
			}
			if(file_exists('../app/views/'. $page .'.php')){
				require_once '../app/views/'. $page .'.php';
			}else{
				die('view not found');
			}
		}
		public function loadHtml($page = [], $data = []){
			require_once '../app/views/index.html';
		}

		public function extract($postData){
			if(is_array($postData)){
				$data = [];
				foreach(array_keys($postData) as $postKey){
					$data[$postKey] = htmlspecialchars(rtrim($postData[$postKey]));
				}

				return $data;
			}else{
				Errors::cant_execute("extract");
			}
		}

		// rules param structure ex: ["required/not_required", "type", "min", "max"]
		// type: text, email, number, confirm_password
		public function validate($data, $rules = []){
			$validatedData = [];
			if(!empty($rules)){
				foreach(array_keys($data) as $dataKey){
					if(array_keys($rules, $rules[$dataKey])){
						if(!empty($rules[$dataKey])){
							if($data[$dataKey] == "" && $rules[$dataKey][0] == 'required'){
								$validatedData[$dataKey] = $dataKey . " is required";
								$validatedData["errors"] = 1;
							}else{
								if(isset($rules[$dataKey][2]) && isset($rules[$dataKey][3])){
									$min = (int) $rules[$dataKey][2];
									$max = (int) $rules[$dataKey][3];
								}
								switch (true) {
									case $rules[$dataKey][1] == "text":
										if(!isset($rules[$dataKey][2]) && !isset($rules[$dataKey][3])){
											$validatedData[$dataKey] = "ok";
											$validatedData["errors"] = 0;
										}else{
											if(strlen($data[$dataKey]) >= $min && strlen($data[$dataKey]) <= $max){
												$validatedData[$dataKey] = "ok";
												$validatedData["errors"] = 0;
											}else{
												$validatedData["errors"] = 1;
												if(strlen($data[$dataKey]) < $min){
													$validatedData[$dataKey] = $dataKey . "must have at least " . $min . " characters";
												}elseif(strlen($data[$dataKey]) > $max){
													$validatedData[$dataKey] = $dataKey . "must be less than " . $max . " characters";
												}

											}
										}
										break;
									case $rules[$dataKey][1] == "email":
										if(!isset($rules[$dataKey][2]) && !isset($rules[$dataKey][3])){
											if($this->is_valid_email($data[$dataKey])){
												$validatedData[$dataKey] = "ok";
											}else{
												$validatedData[$dataKey] = $dataKey . ' is not a valid email';
											}
										}else{
											if(strlen($data[$dataKey]) >= $min && strlen($data[$dataKey]) <= $max){
												if($this->is_valid_email($data[$dataKey])){
													$validatedData[$dataKey] = "ok";
												}else{
													$validatedData[$dataKey] = $dataKey . "is not a valid email";
												}
											}else{
												$validatedData[$dataKey] = "The  lenght of " . $dataKey . " is wromg";
											}
										}
									break;
									case $rules[$dataKey][1] == "number":
										if(!isset($rules[$dataKey][2]) && !isset($rules[$dataKey][3])){
											$validatedData[$dataKey] = "ok";
											$validatedData["errors"] = 0;
										}else{
											if($data[$dataKey] >= $min && $data[$dataKey] <= $max){
												$validatedData[$dataKey] = "ok";
												$validatedData["errors"] = 0;
											}else{
												$validatedData["errors"] = 1;
												if($data[$dataKey] < $min){
													$validatedData[$dataKey] =  $dataKey . "must be at least equal to " . $min ;
												}elseif($data[$dataKey] > $max){
													$validatedData[$dataKey] =  $dataKey . "must be max " . $max;
												}

											}
										}
									break;
									case $rules[$dataKey][1] == "confirm_password":
										if(array_key_exists("password", $validatedData)){
											if($data["password"] == $data["confirm_password"]){
												$validatedData[$dataKey] = "ok";
												$validatedData["errors"] = 0;
											}else{
												$validatedData["errors"] = 1;
												$validatedData[$dataKey] = "passwords do not match";
											}
										}else{
											Errors::cant_execute("validate");
										}
									break;
									default:
										Errors::cant_execute("vaidate");
										break;
								}
							}
						}else{
							$validatedData[$dataKey] = "ok";
						}
					}else{
						dd("no");
					}
				}

				// if($validatedData["errors"] == 1){
				// 	return $validatedData;
				// }else{
				// 	return true;
				// }

				if($validatedData["errors"] == 1){
					unset($validatedData["errors"]);
					return ["status" => false, "data" => $validatedData];
				}else{
					foreach($validatedData as $data){
						if($data == "ok"){
							return true;
						}
					}
					unset($validatedData["errors"]);
				}


			}else{
				// this means that rules array is empty and so just check if some element in data is empty

				if(in_array("", $data)){
					return false;
				}else{
					return true;
				}
			}
		}

		public function setDataErrors($setArr, $getArr){

			foreach(array_keys($getArr["data"]) as $toSetDataKey){
				$setArr[$toSetDataKey . "_err"] = $getArr["data"][$toSetDataKey];
			}

			return $setArr;
		}

		public function is_valid_email($email){
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				return false;
			}else{
				return true;
			}
		}
	}