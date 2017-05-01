// локальные версии списков городов/улиц города
var cities = [];
var streets = [];

function getCityId() {
	var cityIndex = $.inArray($('#in_city_name').val(), cities['names']);
	if (cityIndex == -1)
		return 0;
	return cities['ids'][cityIndex];
}

function getStreetId() {
	var streetIndex = $.inArray($('#in_street_name').val(), streets['names']);
	if (streetIndex == -1)
		return 0;
	return streets['ids'][streetIndex];
}

function initCityPicker() {
	// запрашиваем данные сразу - они не меняются
	$.get(
		'/picker/cities/', '',
		function(data) {
			if (data != false) {
				cities = JSON.parse(data);
				$('#in_city_name').autocomplete({
					source: cities['names'],
					minLength: 0,
					delay: 0,
					autoFocus: true,
				});
				$('#in_city_name').attr('autocomplete', 'on');
			}
		}
	);
}

function filterByTemplate(template, values) {
	var matcher = new RegExp('^' + $.ui.autocomplete.escapeRegex(template), 'i');
	return $.grep(values, function(item) {
		return matcher.test(item);
	});
}

function initStreetPicker() {
	$('#in_street_name').autocomplete({
		source:
			function(request, response) {
				var currentCityId = getCityId();
				if (currentCityId != streets['city']) {
					// город поменялся - запрашиваем новый список улиц
					$.get(
						'/picker/streets/', {'city': currentCityId},
						function(data) {
							if (data != false) {
								streets = JSON.parse(data);
								response(filterByTemplate(request.term, streets['names']));
							} else {
								response([]);
							}
						}
					);
				} else {
					response(filterByTemplate(request.term, streets['names']));
				}
			},
		minLength: 0,
		autoFocus: true,
	});
	$('#in_street_name').attr('autocomplete', 'on');
}

$(document).ready(function() {
	initCityPicker();
	initStreetPicker();

	// инициализация пикера даты рождения
	$.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		changeMonth: true,
		monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Нояб', 'Дек'],
		dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
		dayNamesMin: ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
		dayNamesShort: ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
		firstDay: 1,
	});
	$('#in_birthday').datepicker();

	$('#entry_form').submit(function(e) {
		// перед отправкой определяем id города и улицы по выбранным значениям списков
		var cityId = getCityId();
		var streetId = getStreetId();
		// если улица или город не найдены, прерываем отправку формы
		if (cityId == 0) {
			alert('Город не выбран - необходимо выбрать город');
			e.preventDefault();
		} else if (streetId == 0) {
			alert('Улица не выбрана - необходимо выбрать улицу');
			e.preventDefault();
		} else {
			$('#in_city').val(cityId);
			$('#in_street').val(streetId);
		}
	});
});
