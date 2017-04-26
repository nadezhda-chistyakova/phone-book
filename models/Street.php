<?php

class Street extends Model
{
	public $name;
	public $city;

	static public function tableName() {
		return 'streets';
	}

	static public function fields($forSql) {
		if ($forSql)
			$ownFields = ['m.name', 'm.city'];
		else
			$ownFields = ['name', 'city'];
		return array_merge(parent::fields($forSql), $ownFields);
	}
}
