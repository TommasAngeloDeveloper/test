<?php

namespace base;

class settings
{
	/**
	 * Шаблоны
	 */
	private  $sample = [
		'route' => [
			'alias' => null,
			'btnText' => null,
			'btnTitle' => null,
			'status' => [
				'avtive' => false,
				'msg' => null
			],
			'view' => [
				'nav' => false,
				'footer' => false,
				'aside' => false
			]
		],
		'html' => [
			'Controller' => [
				'link' => false,
				'class' => null,
				'method' => null,
				'data' => [],
			],

		]

	];
	private  $routes = [];
	use \traits\BaseMethods;
}
