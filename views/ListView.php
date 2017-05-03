<h1>Номера телефонов</h1>
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
		<div><a href="/list/add" title="Добавить запись...">Добавить запись</a></div>
	</div>
<?php foreach ($data as $entry) { ?>
	<div class="entry_line">
		<div class="entry_line_large"><?php echo $entry->getFio(); ?></div>
		<div><?php echo $entry->cityName; ?></div>
		<div><?php echo $entry->streetName; ?></div>
		<div><?php echo $entry->phone; ?></div>
		<div><?php echo $entry->birthday; ?></div>
		<div>
			<form
				id="edit<?php echo $entry->id ?>" name="edit<?php echo $entry->id ?>"
				action="/list/edit/" method="GET"
			>
				<input type="hidden" name="id" value=<?php echo '"'.$entry->id.'"'; ?>>
				<input type="submit" value="Редактировать">
			</form>
			<form
				id="delete<?php echo $entry->id ?>" name="delete<?php echo $entry->id ?>"
				class="delete_entry" action="/list/delete/" method="POST"
			>
				<input type="hidden" name="id" value=<?php echo '"'.$entry->id.'"'; ?>>
				<input type="submit" value="Удалить">
			</form>
		</div>
	</div>
<?php } ?>
</div>
