<?php

require 'core/model.php';
require 'core/view.php';
require 'core/controller.php';
require 'core/router.php';
require 'core/Exception.php';

try {
	Router::start();
} catch (PageNotFoundException $e) {
	http_response_code(404);
	echo "<h1>Error 404 Not Found</h1>";
}
