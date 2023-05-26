$.cookie.json = true; // Устанавливаем возможность записывать в куки JSON формат
$checkbox__shipper_name = 'data-checkbox__shipper_name';
$checkbox__shipper_crosses = 'data-checkbox__shipper_crosses';
/**
 * Взять настройки поиска по перевозчикам из чекбоксов
 */
function validate__checkbox_shippers() {
	checkboxes = {};
	$('input[data-search-shipper]').each(function () {

		//добавляем значение каждого флажка в этот массив
		var $input = $(this);
		var $shipper_name = $input.attr('data-shipper_name');
		var $key = $input.attr('data-search-shipper');
		$value = {};
		if ($(this).is(':checked')) {
			if (Object.keys(checkboxes).includes($shipper_name)) {
				checkboxes[$shipper_name][$key] = true;
			} else {
				$value[$key] = true;
				checkboxes[$shipper_name] = $value;
			}
		} else {
			if (Object.keys(checkboxes).includes($shipper_name)) {
				checkboxes[$shipper_name][$key] = false;
			} else {
				$value[$key] = false;
				checkboxes[$shipper_name] = $value;
			}
		}

	});
	return checkboxes;

}
/**
 * Установить куки с настройками поиска перевозчиков
 */
function set_cookie__shippers($values) {
	$.cookie('shippers', $values, { expires: 365, path: '/' });
}
/**
 * Установить настройки из кук
 */
function cookie__shippers() {
	if ($.cookie('shippers')) {

		var $coockies = $.cookie('shippers');

		$.each($coockies, function ($key, $value) {
			$.each($value, function ($key_2, $value_2) {
				var $temp_name_attr = 'data-shipper-' + $key_2 + '="' + $key + '"';
				var $checkbox = $('[' + $temp_name_attr + ']');
				$checkbox.prop('checked', $value_2);
			})
		})
	}
}
$(document).ready(function () {
	cookie__shippers();
	var $chechbox_shiper = $('[data-search-shipper]');
	$chechbox_shiper.on('click',
		function () {
			set_cookie__shippers(validate__checkbox_shippers());
			cookie__shippers();
		});

})