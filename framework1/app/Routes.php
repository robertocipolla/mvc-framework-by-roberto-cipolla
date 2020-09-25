<?php
	class Routes {
		/*  addRoute function takes 4 parameters:
			- the first is the method for that route
			- the second is the endpoint
			- the third is the controller that contains our function
			- the last one is the actual method that we are going to call
		*/
		public function __construct(){
			Route::addRoute("GET","", 'pages', 'index');
			Route::addRoute("GET","create/post", 'posts', 'showCreatePage');
			Route::addRoute("POST", "create/post", 'posts', 'store');
			Route::addRoute("GET", "wela/ciao/comestai", "pages", "ciao");
			Route::addRoute("GET", "contact", "pages", "contact", ["name" => "franco"]);
		}
	}