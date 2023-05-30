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
				'nav' => true,
				'footer' => false
			]
		],
		'news' => [
			'alias' => 'news',
			'btnText' => 'Новости',
			'btnTitle' => 'Новости',
			'folder_name' => 'news/',
			'display' => [
				'nav' => true,
				'footer' => false
			]
		],
		'news_article' => [
			'alias' => 'news_article',
			'btnText' => '',
			'btnTitle' => '',
			'folder_name' => 'news_article/',
			'display' => [
				'nav' => false,
				'footer' => false
			]
		],

	];
	use \traits\BaseMethods;
}
