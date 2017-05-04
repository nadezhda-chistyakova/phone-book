<?php

class Router
{
	static function start() {
		$controllerName = 'list'; // контроллер по умолчанию
		$actionName = 'index';

		// разделяем URI на части и интерпретируем как
		// <имя контроллера>/<имя метода контроллера>
		$chunks = explode('/', $_SERVER['REQUEST_URI'], 4);
		if (isset($chunks[1]) && $chunks[1] != '')
			$controllerName = $chunks[1];
		if (isset($chunks[2]) && $chunks[2] != '')
			$actionName = $chunks[2];
		
		$controllerName = ucfirst($controllerName).'Controller';
		$controllerFile = 'controllers/'.$controllerName.'.php';

		if (file_exists($controllerFile.'')) {
			require_once $controllerFile;
			$actionName = 'action'.ucfirst($actionName);
			$controller = new $controllerName;
			if (method_exists($controller, $actionName)) {
				// если и контроллер, и метод существуют,
				// возобновляем сессию (либо создаём новую) и переходим в метод 
				session_start();
				$controller->$actionName();
			}
			else
				throw new PageNotFoundException();
		} else {
			throw new PageNotFoundException();
		}		
	}
}
