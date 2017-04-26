<?php

require_once 'core/Connection.php';

class Model
{
	public $id;

	static public function tableName() {
		return '';
	}

	static protected function keyField() {
		return 'id';
	}

	static protected function fields() {
		return [];
	}

	static protected function additionalFields() {
		return [];
	}

	static protected function getSQL($cond) {
		// получаем поля объекта, добавляем к ним ключевое поле
		$sqlFields = array_merge([static::keyField()], static::fields());
		// дописываем алиас основной таблицы
		$sqlFields = array_map(function($field) { return 'm.'.$field; }, $sqlFields);
		// добавляем поля других таблиц, соединяем в строку
		$sqlFields = implode(',', array_merge($sqlFields, static::additionalFields()));
		// собираем весь запрос
		$sql = 'SELECT '.$sqlFields.' '.'FROM '.static::tableName().' m '.static::getSQLJoins();
		if ($cond != '')
			$sql .= 'WHERE '.$cond;
		return $sql;
	}

	static protected function getSQLJoins() {
		return '';
	}

	static public function insert($values) {
		throw new NotImplementedException();
	}

	static public function update($values) {
		throw new NotImplementedException();
	}

	static public function delete($id) {
		if (!isset($id))
			throw new DBException('Не указан ID удаляемой записи');
		$sql = 'DELETE FROM '.static::tableName().' WHERE id = ?';
		$con = new Connection();
		$q = $con->con->stmt_init();
		if (!$q->prepare($sql) || !$q->bind_param('i', $id) || !$q->execute())
			throw new DBException($q->error);
	}

	static public function get($id) {
		$con = new Connection();
		$q = $con->con->stmt_init();
		if (!$q->prepare(static::getSQL('m.id = ?')) || !$q->bind_param('i', $id)  || !$q->execute())
			throw new DBException($q->error);
		$data = $q->get_result();
		if (!$data)
			throw new DBException($con->con->errno);
		if ($data->num_rows == 0)
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

	public function init($values) {
		foreach($values as $key => $value)
			$this->$key = $value;
	}
}
