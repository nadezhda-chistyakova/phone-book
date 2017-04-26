<?php

class Entry extends Model
{
	public $lastName;
	public $firstName;
	public $middleName;

	public $city;
	public $street;

	private $cityName;
	private $streetName;

	public $birthday;
	public $phone;

	public function getFio() {
		return implode(' ', [$this->lastName, $this->firstName, $this->middleName]);
	}

	public function getCityName() {
		return $this->cityName;
	}

	public function getStreetName() {
		return $this->streetName;
	}

	static public function get($id) {}

	static public function getAll() {
		// ToDo: считывание из базы
		$entry1 = new Entry();
		$entry1->lastName = 'Антонова';
		$entry1->firstName = 'Александра';
		$entry1->phone = '8-908-48-122-58';
		return [$entry1];
	}
}
