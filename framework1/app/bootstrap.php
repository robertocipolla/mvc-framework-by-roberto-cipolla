<?php
	include_once 'config/Config.php';

	spl_autoload_register(function($className) {
		include_once 'libraries/' . $className . '.php';
	});

	include_once 'helpers/url_helper.php';
	include_once 'helpers/superglobal_helper.php';
	include_once 'helpers/die_and_dump_helper.php';
	include_once 'helpers/validation_helper.php';

	include 'Routes.php';
	include 'Errors.php';