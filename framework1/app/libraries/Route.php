<?php
	class Route {
		public static $chaosRoutes = [];

		public static $orderedRoutes = [];

		// ex: path = 'about/myself
		public static function addRoute($request, $path, $controller, $method = 'index', $params = []){
			$newRoute = [
				"path" => $path,
				"controller" => $controller,
				"method" => $method,
				"params" => $params,
				"request" => $request
			];
			if(!array_key_exists($path, self::$orderedRoutes)){
				array_push(self::$chaosRoutes, $newRoute);
				if(self::formatRoute($newRoute)){
					unset(self::$chaosRoutes);
					return true;
				}else{
					return false;
				}
			}elseif(array_key_exists($path, self::$orderedRoutes) && self::$orderedRoutes[$path]["request"] != $request){
				$sameNameRoute = [
					"path" => $path,
					"controller" => $controller,
					"method" => $method,
					"params" => $params,
					"request" => $request
				];
				if(self::formatRoute($sameNameRoute)){
					return true;
				}else{
					return false;
				}
			}else{
				Errors::cantAddRoute();
			}
		}

		private static function formatRoute($route){
				$path = $route["path"];
				if(!array_key_exists($path, self::$orderedRoutes)){
					self::$orderedRoutes[$path] = [
						"controller" => $route['controller'],
						"method" => $route['method'],
						"params" => $route['params'],
						"request" => $route["request"]
					];
				}else{
					$existantPath = self::$orderedRoutes[$path];
					if($existantPath["request"] != $route["request"]){
						$oldPath = $path . '-'. $existantPath["request"];
						$newPath = $path . '-' . $route["request"];

						self::$orderedRoutes[$oldPath] = self::$orderedRoutes[$path];

						self::$orderedRoutes[$newPath] = [
							"controller" => $route['controller'],
							"method" => $route['method'],
							"params" => $route['params'],
							"request" => $route["request"]
						];
					}else{
						return false;
					}
				}
		}

		public function addParamsArr($path, $params){
			if(array_key_exists($path, self::$orderedRoutes)){
				array_push(self::$orderedRoutes[$path]["params"], $params);
				return true;
			}else{
				return false;
			}
		}

		public function addParam($path, $param){
			if(array_key_exists($path, self::$orderedRoutes)){
				array_push(self::$orderedRoutes[$path]["params"], $param);
				return true;
			}else{
				return false;
			}
		}

		public static function info($path){
			$postPath = $path . '-POST';
			$getPath = $path . '-GET';
			$updatePath = $path . '-PATCH';
			$deletePath = $path . '-DELETE';

			switch (true) {
				case array_key_exists($path, self::$orderedRoutes):
					$data = self::$orderedRoutes[$path];
					return $data;
					break;
				case array_key_exists($postPath, self::$orderedRoutes):
					$data = self::$orderedRoutes[$postPath];
					return $data;
					break;
				case array_key_exists($getPath, self::$orderedRoutes):
					$data = self::$orderedRoutes[$getPath];
					return $data;
					break;
				case array_key_exists($updatePath, self::$orderedRoutes):
					$data = self::$orderedRoutes[$updatePath];
					return $data;
					break;
				case array_key_exists($deletePath, self::$orderedRoutes):
					$data = self::$orderedRoutes[$deletePath];
					return $data;
					break;
				default:
					# code...
					break;
			}



		}


	}