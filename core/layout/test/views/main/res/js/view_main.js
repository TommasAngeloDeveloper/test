$(document).ready(function () {
	$get = getUrlVars();

	if ($get['page']) {
		$(".item_link-wrapper").hover(function () { // задаем функцию при наведении курсора на элемент
			$item = $(this).closest('.block-news_item');
			$item_title = $item.find('.item_title-text');
			$item_title.css('color', '#841844');
		}, function () { // задаем функцию, которая срабатывает, когда указатель выходит из элемента 
			$item = $(this).closest('.block-news_item');
			$item_title = $item.find('.item_title-text');
			$item_title.css('color', 'black');
		});
		$('html, body').animate({
			scrollTop: $(".block-title_page").offset().top // класс объекта к которому приезжаем
		}, 1000); // Скорость прокрутки

	}




})