<?php

namespace footer;

class html
{
	public static function return($method_name, $data = null)
	{

		return self::$method_name($data);
	}
	private static function html($data = null)
	{

		$class = 'company_info\data';
		$method = 'return';
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
		if (!isset($check_ClassAndMethod['error'])) {
			$company_info = $class::$method();
?>


			<footer class="footer">
				<div class="ta_container">
				</div>
			</footer>
<?php
		}
	}
}
?>