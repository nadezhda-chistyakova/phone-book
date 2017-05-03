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
} catch (DBConnectionException $e) {
	http_response_code(500);
	echo "<h1>Internal error</h1>";
	echo $e->getMessage();
} catch (DBException $e) {
	http_response_code(500);
	echo "<h1>Internal error</h1>";
	echo $e->getMessage();
} catch (NotImplementedException $e) {
	http_response_code(500);
	echo "<h1>Internal error</h1>";
	echo $e->getMessage();
}
