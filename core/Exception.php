<?php

class DBConnectionException extends Exception {}
class DBException extends Exception {}

class PageNotFoundException extends Exception {}

class ObjectNotFoundException extends Exception {}

class NotImplementedException extends Exception
{
	public function __construct($class, $function) {
		parent::__construct('Class "'.$class.': function '.$function.' not implemented');
	}
}
