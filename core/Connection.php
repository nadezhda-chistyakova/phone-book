<?php

require 'config.php';

class Connection
{
	public $con;

	public function __construct() {
		$this->con = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($this->con->connect_errno)
			throw new DBConnetionException($this->con->connect_errno.': '.$this->con->connect_error);
	}
}
