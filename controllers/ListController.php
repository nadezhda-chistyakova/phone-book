<?php

require 'models/Entry.php';

class ListController extends Controller
{
	public function actionIndex($args) {
		$entries = Entry::getAll();
		$this->view->render('TemplateView.php', 'ListView.php', $entries);
	}

	public function actionAdd($args) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// ToDo
		} else {
			$data = [
				'entry' => new Entry(),
				'title' => 'Новый номер',
			];
			$this->view->render('TemplateView.php', 'EntryView.php', $data);
		}
	}

	public function actionEdit($args) {
		$data = [ 'title' => 'Редактирование' ];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Entry::update($_POST);
				$data['message'] = 'Изменения сохранены';
				$data['message_kind'] = 'message_success';
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
