<?php

require 'models/Entry.php';

class ListController extends Controller
{
	public function actionIndex($args) {
		$entries = Entry::getAll();
		$this->view->render('TemplateView.php', 'ListView.php', $entries);
	}

	public function actionAdd($args) {}
	public function actionEdit($args) {}
	public function actionDelete($args) {}
}
