<?php

require_once 'models/City.php';
require_once 'models/Street.php';

class PickerController extends Controller
{
	public function actionCities() {
		$res = ['ids' => [], 'names' => []];
		$cities = City::getAll();
		foreach($cities as $city) {
			$res['ids'] []= $city->id;
			$res['names'] []= $city->name;
		}
		echo json_encode($res);
		exit;
	}

	public function actionStreets() {
		$res = ['city' => '', 'ids' => [], 'names' => []];
		$city = $_GET['city'];
		if(isset($city) && $city != 0) {
			$res['city'] = $city;
			$streets = Street::getByCityId($city);
			foreach($streets as $street) {
				$res['ids'] []= $street->id;
				$res['names'] []= $street->name;
			}
		}
		echo json_encode($res);
		exit;
	}
}
