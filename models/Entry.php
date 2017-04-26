<?php

require_once 'models/City.php';
require_once 'models/Street.php';

class Entry extends Model
{
	public $lastName;
	public $firstName;
	public $middleName;

	public $city;
	public $street;

	public $cityName;
	public $streetName;

	public $birthday;
	public $phone;

	public function getFio() {
		return implode(' ', [$this->lastName, $this->firstName, $this->middleName]);
	}

	static public function tableName() {
		return 'entries';
	}

	static protected function fields() {
		return ['lastName', 'firstName', 'middleName', 'birthday', 'city', 'street', 'phone'];
	}

	static protected function additionalFields() {
		return ['c.name AS cityName', 's.name AS streetName'];
	}

	static protected function getSQLJoins() {
		return
			'INNER JOIN '.City::tableName().' c ON c.id = m.city '.
			'INNER JOIN '.Street::tableName().' s ON s.id = m.street ';
	}

	static public function insert($values) {
		// подготавливаем запрос
		$sqlFields = static::fields();
		$sqlParams = array_pad([], count($sqlFields), '?');
		$sql =
			'INSERT INTO '.static::tableName().' '.
			'('.implode(',', $sqlFields).') VALUES ('.implode(',', $sqlParams).')';
		$con = new Connection();
		$q = $con->con->stmt_init();
		if (!$q->prepare($sql))
			throw new DBException($q->error);

		// привязываем параметры и выполняем
		$bindRes = $q->bind_param(
			'ssssiis',
			$values['lastName'], $values['firstName'], $values['middleName'], $values['birthday'],
			$values['city'], $values['street'], $values['phone']);
		if (!$bindRes || !$q->execute())
			throw new DBException($q->error);
	}

	static public function update($values) {
		// подготавливаем запрос
		$sqlFields = static::fields();
		foreach($sqlFields as $key => $field)
			$sqlFields[$key] = $field.'= ?';
		$sql = 'UPDATE '.static::tableName().' SET '.implode(',', $sqlFields).' WHERE id = ?';
		$con = new Connection();
		$q = $con->con->stmt_init();
		if (!$q->prepare($sql))
			throw new DBException($q->error);

		// привязываем параметры и выполняем
		$bindRes = $q->bind_param(
			'ssssiisi',
			$values['lastName'], $values['firstName'], $values['middleName'], $values['birthday'],
			$values['city'], $values['street'], $values['phone'], $values['id']);
		if (!$bindRes || !$q->execute())
			throw new DBException($q->error);
	}
}
