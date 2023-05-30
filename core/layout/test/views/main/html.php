<?php

namespace view;

class html
{
	public static function return($method_name, $data = null)
	{
		return self::$method_name($data);
	}
	private static function html($data = null)
	{
?>
		<div class="page">
			<div class="ta_container">
			</div>
		</div>
<?php
	}
}
?>