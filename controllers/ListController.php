<?php

require 'models/Entry.php';

class ListController extends Controller
{
	public function actionIndex() {
		$entries = Entry::getAll();
		$this->view->render(
			'TemplateView.php', 'ListView.php',
			[
				'entries' => $entries,
				'search' => [
					'on' => false,
					'fio' => '',
					'city' => '',
					'cityName' => '',
				]
			]
		);
	}

	public function actionSearch() {
		$entries = Entry::getFiltered($_GET['fio'], $_GET['city']);
		$this->view->render(
			'TemplateView.php', 'ListView.php',
			[
				'entries' => $entries,
				'search' => [
					'on' => true,
					'fio' => $_GET['fio'],
					'city' => $_GET['city'],
					'cityName' => $_GET['cityName'],
				]
			]
		);
	}

	private function setMessage(&$container, $message, $isSuccess) {
		$container['message'] = $message;
		$container['message_kind'] = $isSuccess ? 'message_success' : 'message_error';
	}

	public function actionAdd() {
		// при GET-запросе предоставляет страницу добавления записи
		// при POST-запросе пытается сохранить запись и при успехе перенаправляет к списку
		$data = ['title' => 'Новая запись'];
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
		if ($_SERVER['REQUEST_METHOD'] == 'POST') // инициализируем сохранёнными значениями
			$data['entry']->init($_POST);
		$this->view->render('TemplateView.php', 'EntryView.php', $data);
	}

	public function actionEdit() {
		// при GET-запросе предоставляет страницу редактирования записи
		// при POST-запросе пытается сохранить изменения и при успехе перенаправляет к списку
		$data = ['title' => 'Редактирование'];
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
		try {
			$data['entry'] = Entry::get($id);
			if ($_SERVER['REQUEST_METHOD'] == 'POST') // инициализируем сохранёнными значениями
				$data['entry']->init($_POST);
		}  catch (ObjectNotFoundException $e) {
			$this->setMessage($_SESSION, 'Запись не найдена', false);
			header('Location: /list', true, 303);
			exit;
		}
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
