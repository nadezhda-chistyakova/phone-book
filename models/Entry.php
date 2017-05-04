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

	public function getBirthday() {
		$date = strtotime($this->birthday);
		if ($date !== false)
			return date('d.m.Y', $date);
		else
			return $this->birthday;
	}

	static public function tableName() {
		return 'entries';
	}

	static protected function orderBy() {
		return 'm.lastName, m.firstName, m.middleName';
	}

	static protected function fields() {
		return ['lastName', 'firstName', 'middleName', 'birthday', 'city', 'street', 'phone'];
	}

	static protected function fieldCaptions() {
		return ['Фамилия', 'Имя', 'Отчество', 'День рождения', 'Город', 'Улица', 'Телефон'];
	}

	static protected function additionalFields() {
		return ['c.name AS cityName', 's.name AS streetName'];
	}

	static protected function getSQLJoins() {
		return
			'INNER JOIN '.City::tableName().' c ON c.id = m.city '.
			'INNER JOIN '.Street::tableName().' s ON s.id = m.street ';
	}

	static public function getFiltered($fio, $city) {
		$con = new Connection();
		$q = $con->con->stmt_init();

		// строим запрос и условие
		$cond = '';
		if ($fio != '') {
			$cond = "CONCAT(m.lastName, ' ', m.firstName, ' ', m.middleName) LIKE ?";
			$fio = '%'.$fio.'%';
		}
		if ($city != '') {
			if ($cond != '')
				$cond .= ' AND ';
			$cond .= 'm.city = ?';
		}
		if (!$q->prepare(static::getSQL($cond)))
			throw new DBException(static::class, $q->error, $q->errno);

		// привязываем параметры
		$r = true;
		if ($fio != '' && $city != '') {
			$r = $q->bind_param('si', $fio, $city);
		} else if ($fio != '') {
			$r = $q->bind_param('s', $fio);
		} else if ($city != '') {
			$r = $q->bind_param('i', $city);
		}
		if (!$r || !$q->execute())
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

	static protected function prepareParams($rawParams) {
		// заменяем пустые строки в списке параметров на null
		$res = $rawParams;
		foreach(['lastName', 'firstName', 'middleName', 'birthday', 'phone'] as $strParam)
			$res[$strParam] = $rawParams[$strParam] == '' ? null : $rawParams[$strParam];
		// преобразуем дату в нужный формат
		if (!is_null($res['birthday'])) {
			$date = strtotime($res['birthday']);
			if ($date !== false)
				$res['birthday'] = date('Y-m-d', $date);
		}
		return $res;
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
			throw new DBException(static::class, $q->error, $q->errno);

		// привязываем параметры и выполняем
		$params = static::prepareParams($values);
		$bindRes = $q->bind_param(
			'ssssiis',
			$params['lastName'], $params['firstName'], $params['middleName'], $params['birthday'],
			$params['city'], $params['street'], $params['phone']);
		if (!$bindRes || !$q->execute())
			throw new DBException(static::class, $q->error, $q->errno);
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
			throw new DBException(static::class, $q->error, $q->errno);

		// привязываем параметры и выполняем
		$params = static::prepareParams($values);
		$bindRes = $q->bind_param(
			'ssssiisi',
			$params['lastName'], $params['firstName'], $params['middleName'], $params['birthday'],
			$params['city'], $params['street'], $params['phone'], $params['id']);
		if (!$bindRes || !$q->execute())
			throw new DBException(static::class, $q->error, $q->errno);
	}
}
