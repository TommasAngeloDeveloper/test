<?php

namespace view;

class config
{
	private $config  = [
		'meta' => [
			'title' => [
				'value' => 'Главная'
			],
			'description' => [
				'value' => 'Главная'
			],
			'keywords' => [
				'value' => [],
			],
		],
		'require' => null,
		'param' => [
			'page_title' => 'Главная'
		],
	];
	use \traits\BaseMethods;
}
