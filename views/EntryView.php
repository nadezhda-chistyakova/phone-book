<h1><?php echo $data['title']; ?></h1>
<div class="navigation">
	<a href="/list" title="Вернуться к списку номеров">Назад к списку</a>
</div>
<?php
	if (isset($data['message']))
		echo '<div class="message '.$data['message_kind'].'">'.$data['message'].'</div>';
?>
<form action="" name="EntryForm" method="POST">
	<div>
		<div class="entry_input_block">
			<div class="entry_input"><label>
				<span>Фамилия:</span><input name="lastName" value=<?php echo '"'.$data['entry']->lastName.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span>Имя:</span><input name="firstName" value=<?php echo '"'.$data['entry']->firstName.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span>Отчество:</span><input name="middleName" value=<?php echo '"'.$data['entry']->middleName.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span>День рождения:</span><input id="in_birthday" name="birthday" value=<?php echo '"'.$data['entry']->birthday.'"'?>>
			</label></div>
		</div>
		<div class="entry_input_block">
			<div class="entry_input"><label>
				<span>Город:</span><input name="city" value=<?php echo '"'.$data['entry']->city.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span>Улица:</span><input name="street" value=<?php echo '"'.$data['entry']->street.'"'?>>
			</label></div>
			<div class="entry_input"><label>
				<span>Телефон:</span><input name="phone" value=<?php echo '"'.$data['entry']->phone.'"'?>>
			</label></div>
		</div>
		<div class="entry_input_footer">
			<input name="id" type="hidden" value=<?php echo '"'.$data['entry']->id.'"'?>>
			<input type="submit" value="Сохранить">
		</div>
	</div>
</form>
