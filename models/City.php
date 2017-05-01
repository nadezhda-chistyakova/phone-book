<?php

class City extends Model
{
	public $name;

	static public function tableName() {
		return 'cities';
	}

	static protected function orderBy() {
		return 'm.name';
	}

	static protected function fields() {
		return ['name'];
	}
}
