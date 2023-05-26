<?php

namespace layout;

class html
{
	private static $settings;
	function __construct($settings)
	{
		//	print_array_1($settings);
		self::$settings = $settings;
		/* view */

		self::html();
	}
	private static function html()
	{

		/* meta */
		$link = self::$settings['html']['meta']['Controller']['link'];
		$include = \system\functions\sub::include($link);
		if (isset($include['error'])) {
			new \Ex($include['error']);
		} else {
			$class = self::$settings['html']['meta']['Controller']['class'];
			$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class);
			if (isset($check_ClassAndMethod['error'])) {
				new \Ex($check_ClassAndMethod['error']);
			} else {
				$class_meta = $class;
			}
		}

		/* nav */
		if (isset(self::$settings['html']['nav'])) {
			$class = self::$settings['html']['nav']['class'];
			$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class);
			if (isset($check_ClassAndMethod['error'])) {
				new \Ex($check_ClassAndMethod['error']);
			} else {
				$class_nav = $class;
			}
		} else {
			if ($_SESSION['auth_a'] === true) {
				new \Ex('no exists "nav"');
			}
		}

		/* aside */
		if (isset(self::$settings['html']['aside'])) {
			$class = self::$settings['html']['aside']['class'];
			$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class);
			if (isset($check_ClassAndMethod['error'])) {
				new \Ex($check_ClassAndMethod['error']);
			} else {
				$class_aside = $class;
			}
		} else {
			if ($_SESSION['auth_a'] === true) {
				new \Ex('no exists "aside"');
			}
		}
		/* view */
		$class = self::$settings['html']['view']['class'];
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class);
		if (isset($check_ClassAndMethod['error'])) {
			new \Ex($check_ClassAndMethod['error']);
		} else {
			$class_view = $class;
		}

?>
		<!DOCTYPE html>
		<html lang="ru">

		<head>
			<?php
			/* meta */
			new $class_meta(self::$settings['html']['meta']['data']);

			?>
		</head>

		<body>
			<?php

			/* aside */
			if (isset($class_aside)) {
				$class_aside::return(['return' => ['html' => null]]);
			}
			?>
			<main>

				<?php
				/* nav */
				if (isset($class_nav)) {
					$class_nav::return(['return' => ['html' => null]]);
				}
				/* page_title */
				self::page_title();
				/* view */
				$class_view::return(['return' => ['html' => null]]);

				?>
			</main>
			<?php

			?>
		</body>

		</html>
	<?php
	}
	private static function page_title()
	{

	?>
		<div class="ta_container page_title">
			<div class="block-page_title">
				<div class="page_title-container">
					<div class="page_title-wrapper">
						<div class="page_title-text">
							<?= self::$settings['html']['view']['param']['page_title'] ?>
						</div>
					</div>
				</div>
			</div>
		</div>

<?

	}
}
?>