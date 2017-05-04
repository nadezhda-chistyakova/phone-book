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

	static protected function orderBy() {
		return 'id';
	}

	static protected function fields() {
		return [];
	}

	static protected function fieldCaptions() {
		return [];
	}

	static protected function additionalFields() {
		return [];
	}

	static public function fieldCaption($field) {
		// возвращает понятный пользователю заголовок поля
		// либо название поля, если заголовок не найден
		$res = $field;
		$idx = array_search($field, static::fields());
		if ($idx !== false) {
			$caption = static::fieldCaptions()[$idx];
			if (isset($caption))
				$res = $caption;
		}
		return $res;
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
			$sql .= 'WHERE '.$cond.' ';
		if (static::orderBy() != '')
			$sql .= 'ORDER BY '.static::orderBy();
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
		// удаление записи по ID
		if (!isset($id))
			throw new DBException(static::class, 'Не указан ID удаляемой записи', false);
		$sql = 'DELETE FROM '.static::tableName().' WHERE id = ?';
		$con = new Connection();
		$q = $con->con->stmt_init();
		if (!$q->prepare($sql) || !$q->bind_param('i', $id) || !$q->execute())
			throw new DBException(static::class, $q->error, $q->errno);
	}

	static public function getByAnyId($field, $id) {
		// выбор записи или записей по условию $field = $id
		$con = new Connection();
		$q = $con->con->stmt_init();
		if (!$q->prepare(static::getSQL($field.' = ?')) || !$q->bind_param('i', $id)  || !$q->execute())
			throw new DBException(static::class, $q->error, $q->errno);
		$data = $q->get_result();
		if (!$data)
			throw new DBException(static::class, $con->con->errno, $q->errno);
		$res = [];
		while ($row = $data->fetch_assoc()) {
			$obj = new static();
			$obj->init($row);
			$res []= $obj;
		}
		return $res;
	}

	static public function get($id) {
		$allObjs =  static::getByAnyId('m.id', $id);
		if (count($allObjs) == 0)
			throw new ObjectNotFoundException();
		return $allObjs[0];
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
