$(document).ready(function () {
	$("img.arrow_img-svg").each(function () {
		var $img = $(this);
		var imgClass = $img.attr("class");
		var imgURL = $img.attr("src");
		$.get(imgURL, function (data) {
			var $svg = $(data).find("svg");
			if (typeof imgClass !== "undefined") {
				$svg = $svg.attr("class", imgClass + " replaced-svg");
			}
			$svg = $svg.removeAttr("xmlns:a");
			if (!$svg.attr("viewBox") && $svg.attr("height") && $svg.attr("width")) {
				$svg.attr("viewBox", "0 0 " + $svg.attr("height") + " " + $svg.attr("width"))
			}
			$img.replaceWith($svg);
		}, "xml");
	});

	$(".item_link-wrapper").hover(function () { // задаем функцию при наведении курсора на элемент
		$item = $(this).closest('.block-news_item');
		$item_title = $item.find('.item_title-text');
		$item_title.css('color', '#841844');
		//$(this).css("background", "#841844") // задаем цвет заднего фона
	}, function () { // задаем функцию, которая срабатывает, когда указатель выходит из элемента 
		$item = $(this).closest('.block-news_item');
		$item_title = $item.find('.item_title-text');
		$item_title.css('color', 'black');
	});
})