<?php

class Street extends Model
{
	public $name;
	public $city;

	static public function tableName() {
		return 'streets';
	}

	static protected function fields() {
		return ['name', 'city'];
	}
}
