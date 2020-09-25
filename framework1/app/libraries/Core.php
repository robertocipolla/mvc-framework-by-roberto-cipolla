<?php

	class Core extends Route{

		protected $currentController = '';
		protected $currentMethod = '';
		protected $params = array();

		public function __construct(){

			$url = $this->getUrl();

			$path = $this->checkPath($url);
			if($path !== false){
				$requiredController = self::$orderedRoutes[$path]['controller'];
				$requiredMethod = self::$orderedRoutes[$path]['method'];
				if(file_exists('../app/controllers/' . $requiredController . '.php')){
					$this->currentController = ucwords($requiredController);
				}else{
					Errors::notFound();
				}

					require_once '../app/controllers/' . $this->currentController . '.php';

				$this->currentController = new $this->currentController;

				if(method_exists($this->currentController, $requiredMethod)){
					$this->currentMethod = $requiredMethod;
				}else{
					Errors::notFound();
				}


				if(isset($url[1])){
					$params_arr = $this->checkParam($url[1], $path);
					if($params_arr != false){
						// means that given params are correct and can move on
						$this->params = array_values($params_arr);
					}else{
						Errors::notFound();
					}
				}elseif(!isset($url[1])){
					// function does not expect params, we are passing a blank array
					$params_arr = $this->checkParam([], $path);
					if($params_arr != false){
						// means that given params are correct and can move on
						if(is_array($params_arr)){
							$this->params = array_values($params_arr);
						}else{
							$this->params = [];
						}
					}else{
						Errors::notFound();
					}
				}


				call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

			}else{
				Errors::notFound();
			}
		}

		private function checkPath($url){
			// $this->addRoute('about/me','pages');

			$url_arr = explode("/", $url[0]);
			// this means that's a final slash
			if(array_search("", $url_arr)){
				$del = array_search("", $url_arr);
				unset($url_arr[$del]);
				$cleanedPath = implode("/", $url_arr);
				redirect($cleanedPath);
			}elseif(!array_key_exists($url[0], self::$orderedRoutes)){
				// this means that route is not found
				Errors::notFound();
				return false;
			}else{
				// this means that route has been found, and page can be loaded
				$path = $url[0];
				unset($url[0]);
				if(is_null($path)){
					$path_null = "";
					return $path_null;
				}else{
					return $path;
				}
			}
		}

		private function checkParam($url, $path){
			if(array_key_exists($path, self::$orderedRoutes)){
				if(!is_array($url)){
					$url_arr = explode('-', $url);
					if(!empty($url_arr)){
						if(!empty(array_diff($url_arr,self::$orderedRoutes[$path]["params"]))){
							return false;
						}else{
							// this means that all given params are correct
						return $url_arr;
						}
					}else{
						Errors::general();
					}
				}else{
					if(count($url) == count(self::$orderedRoutes[$path]["params"])){
						return true;
					}else {
						return false;
					}
				}
			}else{
				Errors::notFound();
			}
		}

		private function getUrl(){
			if(isset($_GET['url'])){
				$url = rtrim($_GET['url'], '|');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('|', $url);
				return $url;
			}
		}
	}