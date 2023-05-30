<?php

namespace view;

class config
{
	private $config  = [
		'meta' => [
			'title' => [
				'value' => 'Новости'
			],
			'description' => [
				'value' => 'Новости'
			],
			'keywords' => [
				'value' => [],
			],
		],
		'require' => null,
		'param' => [
			'page_title' => 'Новости'
		],
	];
	use \traits\BaseMethods;
}
