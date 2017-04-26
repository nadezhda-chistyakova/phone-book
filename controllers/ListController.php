<?php

require 'models/Entry.php';

class ListController extends Controller
{
	public function actionIndex($args) {
		$entries = Entry::getAll();
		$this->view->render('TemplateView.php', 'ListView.php', $entries);
	}

	public function actionAdd($args) {
		$data = [ 'title' => 'Новая запись' ];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Entry::insert($_POST);
				header('Location: /list', true, 303);
				exit;
			} catch (DBException $e) {
				$data['message'] = 'Ошибка при сохранении записи: '.$e->getMessage();
				$data['message_kind'] = 'message_error';
			}
		}
		$data['entry'] = new Entry();
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
			$data['entry']->init($_POST);
		$this->view->render('TemplateView.php', 'EntryView.php', $data);
	}

	public function actionEdit($args) {
		$data = [ 'title' => 'Редактирование' ];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Entry::update($_POST);
				header('Location: /list', true, 303);
				exit;
			} catch (DBException $e) {
				$data['message'] = 'Ошибка при сохранении изменений: '.$e->getMessage();
				$data['message_kind'] = 'message_error';
			}
		}
		$data['entry'] = Entry::get($args);
		$this->view->render('TemplateView.php', 'EntryView.php', $data);
	}

	public function actionDelete($args) {}
}
