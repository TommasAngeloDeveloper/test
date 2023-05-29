<?php

namespace view;

class Controller
{
	use \traits\Singleton_Controller;

	public static function param($param = null)
	{
		//	print_array_1(print_array_1($param));
		$news_id = $param['url_array'][1];
		$news = \layuot\db\read::return('get_work_news', $news_id); // Списк новостей
		$view_param = [
			'meta' =>
			[
				'title' => [
					'value' => $news['title']
				],
				'description' => [
					'value' => $news['announce']
				],
				'keywords' => [
					'value' => ''
				]
			],
			'content' => $news
		];
		return $view_param;
	}
	private static function html($data)
	{
		$link = 'html.php';
		if (!@include_once($link)) {
			new \Ex(\ExDetailsText::include($link), 'view', 12);
		} else {
			return html::return('html', $data);
		}
	}
}
