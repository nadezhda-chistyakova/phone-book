<?php

require 'models/Entry.php';

class ListController extends Controller
{
	public function actionIndex() {
		$entries = Entry::getAll();
		$this->view->render('TemplateView.php', 'ListView.php', $entries);
	}

	private function setMessage(&$container, $message, $isSuccess) {
		$container['message'] = $message;
		$container['message_kind'] = $isSuccess ? 'message_success' : 'message_error';
	}

	public function actionAdd() {
		$data = [ 'title' => 'Новая запись' ];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Entry::insert($_POST);
				$this->setMessage($_SESSION, 'Запись успешно добавлена', true);
				header('Location: /list', true, 303);
				exit;
			} catch (DBException $e) {
				$this->setMessage($data, 'Ошибка при сохранении записи: '.$e->getMessage(), false);
			}
		}
		$data['entry'] = new Entry();
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
			$data['entry']->init($_POST);
		$this->view->render('TemplateView.php', 'EntryView.php', $data);
	}

	public function actionEdit() {
		$data = [ 'title' => 'Редактирование' ];
		$id = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['id'] : $_GET['id'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Entry::update($_POST);
				$this->setMessage($_SESSION, 'Изменения сохранены', true);
				header('Location: /list', true, 303);
				exit;
			} catch (DBException $e) {
				$this->setMessage($data, 'Ошибка при сохранении изменений: '.$e->getMessage(), false);
			}
		}
		$data['entry'] = Entry::get($id);
		$this->view->render('TemplateView.php', 'EntryView.php', $data);
	}

	public function actionDelete() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Entry::delete($_POST['id']);
				$this->setMessage($_SESSION, 'Запись удалена', true);
			} catch (DBException $e) {
				$this->setMessage($_SESSION, 'Ошибка при удалении записи: '.$e->getMessage(), false);
			}
		}
		header('Location: /list', true, 303);
		exit;
	}
}
