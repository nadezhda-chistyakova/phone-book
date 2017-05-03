<?php

class DBConnectionException extends Exception {}

class DBException extends Exception
{
	public function __construct($class, $message, $errno) {
		$msg = $message;
		switch ($errno) {
			case 1048:
				// ошибка - нарушение ограничения NOT NULL
				// Column 'fieldName' cannot be null
				$field = trim(explode(' ', $message)[1], '\'');
				$msg = 'Поле "'.$class::fieldCaption($field).'" не может быть пустым';
				break;
			case 1292:
				// ошибка - неправильный формат даты
				// Incorrect date value: 'dateStr' for column 'fieldName' at row 1
				$words = explode(' ', $message);
				$field = trim($words[6], '\'');
				$value = trim($words[3], '\'');
				$msg = 'Некорректное значение даты "'.$value.'" в поле "'.$class::fieldCaption($field).'"';
				break;
		}
		parent::__construct($msg);
	}
}

class PageNotFoundException extends Exception {}

class ObjectNotFoundException extends Exception {}

class NotImplementedException extends Exception
{
	public function __construct($class, $function) {
		parent::__construct('Class "'.$class.': function '.$function.' not implemented');
	}
}
