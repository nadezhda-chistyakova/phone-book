<?php

require_once 'core/Connection.php';

class Model
{
	private $id;

	static public function tableName() {
		return '';
	}

	static protected function fields($forSql) {
		if ($forSql)
			return ['m.id'];
		else
			return ['id'];
	}

	static protected function getSQL($cond) {
		$sql =
			'SELECT '.implode(',', static::fields(true)).' '.
			'FROM '.static::tableName().' m '.
			static::getSQLJoins();
		if ($cond != '')
			$sql .= 'WHERE '.$cond;
		return $sql;
	}

	static protected function getSQLJoins() {
		return '';
	}

	static public function get($id) {
		$con = new Connection();
		$pq = $con->con->prepare(static::getSQL('id = ?'));
		if (!$pq->bind_param('i', $id) || !($data = $pq->execute()) || ($data->num_rows == 0))
			throw new ObjectNotFoundException();
		$row = $data->fetch_assoc();
		$res = new static();
		$res->init($row);
		return $res;
	}

	static public function getAll() {
		$con = new Connection();
		$data = $con->con->query(static::getSQL(''));
		$res = [];
		while ($row = $data->fetch_assoc()) {
			$obj = new static();
			$obj->init($row);
			$res []= $obj;
		}
		return $res;
	}

	protected function init($row) {
		foreach($row as $key => $value)
			$this->$key = $value;
	}
}
