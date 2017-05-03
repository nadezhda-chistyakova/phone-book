<h1><?php echo $data['title']; ?></h1>
<div class="navigation">
	<a href="/list" title="Вернуться к списку номеров">Назад к списку</a>
</div>
<?php
	if (isset($data['message']))
		echo '<div class="message '.$data['message_kind'].'">'.$data['message'].'</div>';
?>
<form action="" id="entry_form" name="EntryForm" method="POST">
	<div>
		<div class="entry_input_block">
			<div class="entry_input"><label>
				<span class="in_label">Фамилия:</span>
				<input name="lastName" value=<?php echo '"'.$data['entry']->lastName.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span class="in_label">Имя:</span>
				<input name="firstName" value=<?php echo '"'.$data['entry']->firstName.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span class="in_label">Отчество:</span>
				<input name="middleName" value=<?php echo '"'.$data['entry']->middleName.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span class="in_label">День рождения:</span>
				<input id="in_birthday" name="birthday" value=<?php echo '"'.$data['entry']->getBirthday().'"'?>>
			</label></div>
		</div>
		<div class="entry_input_block">
			<div class="entry_input"><label>
				<span class="in_label">Город:</span>
				<input id="in_city" type="hidden" name="city" value=<?php echo '"'.$data['entry']->city.'"'?>>
				<input
					id="in_city_name"
					name="cityName"
					value=<?php echo '"'.$data['entry']->cityName.'"'?>
					placeholder="Начните ввод"
				>
			</label></div>
			<div class="entry_input"><label>
				<span class="in_label">Улица:</span>
				<input id="in_street" type="hidden" name="street" value=<?php echo '"'.$data['entry']->street.'"'?>>
				<input
					id="in_street_name"
					name="streetName"
					value=<?php echo '"'.$data['entry']->streetName.'"'?>
					placeholder="Начните ввод"
				>
			</label></div>
			<div class="entry_input">
				<span class="hint">Нажмите BACKSPACE, чтобы увидеть все варианты<span>
			</div>
			<div class="entry_input"><label>
				<span class="in_label">Телефон:</span>
				<input id="in_phone" name="phone" value=<?php echo '"'.$data['entry']->phone.'"'?>>
			</label></div>
		</div>
		<div class="entry_input_footer">
			<input name="id" type="hidden" value=<?php echo '"'.$data['entry']->id.'"'?>>
			<input type="submit" value="Сохранить">
		</div>
	</div>
</form>
