<?php

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/router.php';

try {
	Router::start();
} catch (Exception $e) {
	// ToDo: типизированное исключение
	http_response_code(404);
	echo "<h1>Error 404 Not Found</h1>";
}
