<h1>Номера телефонов</h1>
<div>
<?php foreach ($data as $entry) { ?>
	<div class="entry_line">
		<div><?php echo $entry->getFio(); ?></div>
		<div><?php echo $entry->getCityName(); ?></div>
		<div><?php echo $entry->getStreetName(); ?></div>
		<div><?php echo $entry->phone; ?></div>
		<div><?php echo $entry->birthday; ?></div>
	</div>
<?php } ?>
</div>
