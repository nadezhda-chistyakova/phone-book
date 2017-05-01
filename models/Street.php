<?php

class Street extends Model
{
	public $name;
	public $city;

	static public function tableName() {
		return 'streets';
	}

	static protected function orderBy() {
		return 'm.name';
	}

	static protected function fields() {
		return ['name', 'city'];
	}

	static public function getByCityId($city) {
		return static::getByAnyId('m.city', $city);
	}
}
