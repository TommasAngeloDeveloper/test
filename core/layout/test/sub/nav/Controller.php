<?php

namespace nav;

class Controller
{
	use \traits\Singleton_Controller;

	private static function html($data)
	{
		$link = 'html.php';
		if (!@include_once($link)) {
			new \Ex(\ExDetailsText::include($link), 'view', 12);
		} else {
			return html::return('html');
		}
	}
}
