<h1>Номера телефонов</h1>
<div>
	<div class="entry_line entry_header">
		<div>ФИО</div>
		<div>Город</div>
		<div>Улица</div>
		<div>Телефон</div>
		<div>День рождения</div>
		<div></div>
	</div>
<?php foreach ($data as $entry) { ?>
	<div class="entry_line">
		<div><?php echo $entry->getFio(); ?></div>
		<div><?php echo $entry->cityName; ?></div>
		<div><?php echo $entry->streetName; ?></div>
		<div><?php echo $entry->phone; ?></div>
		<div><?php echo $entry->birthday; ?></div>
		<div><a href="/list/edit/<?php echo $entry->id ?>" title="Редактировать запись...">Редактировать</a></div>
	</div>
<?php } ?>
</div>
