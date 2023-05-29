<?php

namespace view;

class Controller
{
	use \traits\Singleton_Controller;

	public static function param()
	{
		$view_param = [
			'meta' =>
			[
				'title' => [
					'value' => 'Главная'
				],
				'description' => [
					'value' => ''
				],
				'keywords' => [
					'value' => ''
				]
			]
		];
		return $view_param;
	}
	private static function html($data)
	{
		$link = 'html.php';
		if (!@include_once($link)) {
			new \Ex(\ExDetailsText::include($link), 'view', 12);
		} else {
			return html::return('html');
		}
	}
}
