<?php

class City extends Model
{
	public $name;

	static public function tableName() {
		return 'cities';
	}

	static protected function fields() {
		return ['name'];
	}
}
