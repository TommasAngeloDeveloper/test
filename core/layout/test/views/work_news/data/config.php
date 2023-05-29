<?php

namespace view;

class config
{
	private $config  = [
		'meta' => [
			'title' => [
				'value' => ''
			],
			'description' => [
				'value' => ''
			],
			'keywords' => [
				'value' => [],
			],
		],
		'require' => null,
		'param' => [
			'page_title' => ''
		],
	];
	use \traits\BaseMethods;
}
