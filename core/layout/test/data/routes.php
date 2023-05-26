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
		'catalog' => [
			'alias' => 'catalog',
			'btnText' => 'каталог',
			'btnTitle' => 'каталог тестовой продукции',
			'folder_name' => 'catalog/',
			'display' => [
				'nav' => true,
				'footer' => false
			]
		],

	];
	use \traits\BaseMethods;
}
