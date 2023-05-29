<?php

namespace layout;

class config
{
	private $config = [
		'meta' => [
			'title_prefix' => [
				'status' => true,
				'value' => ''
			],
			'title_page' => [
				'status' => false,
				'value' => false
			]
		]
	];
	use \traits\BaseMethods;
}
