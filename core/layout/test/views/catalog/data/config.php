<?php

namespace view;

class config
{
	private $config  = [
		'meta' => [
			'title' => [
				'value' => 'Каталог'
			],
			'description' => [
				'value' => 'Каталог'
			],
			'keywords' => [
				'value' => [],
			],
		],
		'require' => null,
		'param' => [
			'page_title' => 'Каталог'
		],
	];
	use \traits\BaseMethods;
}
