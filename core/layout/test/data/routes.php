<?php

namespace layout;

class routes
{
	/**
	 * маршруты
	 */
	private $routes = [
		'main' => [
			'alias' => '',
			'btnText' => 'Главная',
			'btnTitle' => 'layout',
			'folder_name' => 'main/',
			'display' => [
				'nav' => false,
				'footer' => false
			]
		],
		'work_news' => [
			'alias' => 'work_news',
			'btnText' => '',
			'btnTitle' => '',
			'folder_name' => 'work_news/',
			'display' => [
				'nav' => false,
				'footer' => false
			]
		],

	];
	use \traits\BaseMethods;
}
