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

	static public function fields($forSql) {
		if ($forSql)
			$ownFields = [
				'm.lastName', 'm.firstName', 'm.middleName', 'm.birthday',
				'm.city', 'm.street', 'm.phone', 'c.name AS cityName', 's.name AS streetName'];
		else
			$ownFields = [
				'lastName', 'firstName', 'middleName', 'birthday',
				'city', 'street', 'phone', 'cityName', 'streetName'];
		return array_merge(parent::fields($forSql), $ownFields);
	}

	static protected function getSQLJoins() {
		return
			'INNER JOIN '.City::tableName().' c ON c.id = m.city '.
			'INNER JOIN '.Street::tableName().' s ON s.id = m.street ';
	}
}
