<?php

class City extends Model
{
	public $name;

	static public function tableName() {
		return 'cities';
	}

	static public function fields($forSql) {
		if ($forSql)
			$ownFields = ['m.name'];
		else
			$ownFields = ['name'];
		return array_merge(parent::fields($forSql), $ownFields);
	}
}
