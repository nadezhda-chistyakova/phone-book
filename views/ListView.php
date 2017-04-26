<h1>Номера телефонов</h1>
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
			<a href="/list/edit/<?php echo $entry->id ?>" title="Редактировать запись...">Редактировать</a>
			<a href="/list/delete/<?php echo $entry->id ?>" title="Удалить запись">Удалить</a>
		</div>
	</div>
<?php } ?>
</div>
