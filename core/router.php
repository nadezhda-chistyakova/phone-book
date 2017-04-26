<?php

class Router
{
	static function start() {
		$controllerName = 'list'; // контроллер по умолчанию
		$actionName = 'index';
		$args = '';
		$chunks = explode('/', $_SERVER['REQUEST_URI'], 4);
		if (isset($chunks[1]))
			$controllerName = $chunks[1];
		if (isset($chunks[2]) && $chunks[2] != '')
			$actionName = $chunks[2];
		if (isset($chunks[3]))
			$args = $chunks[3];
		
		$controllerName = ucfirst($controllerName).'Controller';
		$controllerFile = 'controllers/'.$controllerName.'.php';

		if (file_exists($controllerFile.'')) {
			require_once $controllerFile;
			$actionName = 'action'.ucfirst($actionName);
			$controller = new $controllerName;
			if (method_exists($controller, $actionName))
				$controller->$actionName($args);
			else
				throw new PageNotFoundException();
		} else {
			throw new PageNotFoundException();
		}		
	}
}
