<?php

class Connection
{
	public $con;

	public function __construct() {
		// ToDo: settings
		$this->con = new \mysqli("127.0.0.1:3306", "pb_app", "pb_app_pwd", "phoneBook");
		if ($this->con->connect_errno)
			throw new DBConnetionException($this->con->connect_errno.': '.$this->con->connect_error);
	}
}
