<?php

namespace layout;

class config
{
	private $config = [
		'meta' => [
			'title_prefix' => [
				'status' => true,
				'value' => 'TEST_@'
			],
			'title_page' => [
				'status' => true,
				'value' => false
			]
		]
	];
	use \traits\BaseMethods;
}
