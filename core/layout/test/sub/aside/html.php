<?php

namespace aside;

class html
{
	public static function return($method_name, $data = null)
	{

		return self::$method_name($data);
	}
	private static function html($data = null)
	{
		$routes =	\layout\Controller::return(['return' => [
			'return_Data' => ['routes' => 'routes']
		]]);
		if (isset($routes['error'])) {
			new \Ex($routes['error']);
		} else {
?>


			<aside class="aside">
				<div class="aside-container">
					<div class="aside-wrapper">

					</div>
				</div>

			</aside>
<?php
		}
	}
}
?>