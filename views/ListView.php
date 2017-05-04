<h1>Номера телефонов</h1>
<?php if ($data['search']['on']) { ?>
	<div class="navigation">
		<a href="/list" title="Вернуться к полному списку номеров">Назад к полному списку</a>
	</div>
<?php } ?>
<?php
	if (isset($_SESSION['message'])) {
		echo '<div class="message '.$_SESSION['message_kind'].'">'.$_SESSION['message'].'</div>';
		unset($_SESSION['message']);
		unset($_SESSION['message_kind']);
	}
?>
<div>
	<div class="entry_line entry_header">
		<div class="entry_line_large">ФИО</div>
		<div>Город</div>
		<div>Улица</div>
		<div>Телефон</div>
		<div>День рождения</div>
		<div class="entry_line_medium"><a href="/list/add" title="Добавить запись...">Добавить запись</a></div>
	</div>
	<div class="entry_line entry_header">
		<form id="list_search_form" name="listSearch" action="/list/search/" method="GET">
			<div class="entry_line_large">
				<input class="entry_search" name="fio" value=<?php echo '"'.$data['search']['fio'].'"'; ?>>
				<span class="list_search_btn btn_search ui-icon ui-icon-search"></span>
			</div>
			<div>
				<input type="hidden" id="in_city" name="city" value=<?php echo '"'.$data['search']['city'].'"'; ?>>
				<input
					class="entry_search" id="in_city_name" name="cityName"
					value=<?php echo '"'.$data['search']['cityName'].'"'; ?>
					placeholder="Начните ввод"
				>
				<span class="list_search_btn btn_search ui-icon ui-icon-search"></span>
			</div>
			<div></div>
			<div></div>
			<div></div>
			<div class="entry_line_medium"></div>
		</form>
	</div>
<?php
$count = 0;
foreach ($data['entries'] as $entry) {
?>
	<div class="entry_line <?php if ($count / 5 % 2 == 1) echo 'entry_line_odd'; else echo 'entry_line_even'; ?>">
		<div class="entry_line_large"><?php echo $entry->getFio(); ?></div>
		<div><?php echo $entry->cityName; ?></div>
		<div><?php echo $entry->streetName; ?></div>
		<div><?php echo $entry->phone; ?></div>
		<div><?php echo $entry->getBirthday(); ?></div>
		<div class="entry_line_medium">
			<form
				id="edit<?php echo $entry->id ?>" name="edit<?php echo $entry->id ?>"
				class="inline_form" action="/list/edit/" method="GET"
			>
				<input type="hidden" name="id" value=<?php echo '"'.$entry->id.'"'; ?>>
				<input type="submit" value="Редактировать">
			</form>
			<form
				id="delete<?php echo $entry->id ?>" name="delete<?php echo $entry->id ?>"
				class="inline_form delete_entry" action="/list/delete/" method="POST"
			>
				<input type="hidden" name="id" value=<?php echo '"'.$entry->id.'"'; ?>>
				<input type="submit" value="Удалить">
			</form>
		</div>
	</div>
<?php
	$count++;
}
?>
</div>
