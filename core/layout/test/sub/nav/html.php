<?php

namespace nav;

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
			$url_array = url_array();

?>


			<nav class="nav">
				<div class="nav__container">
					<div class="nav__wrapper">
						<div class="ta_container">

							<?php
							foreach ($routes['routes'] as $key => $result) {

								if (isset($result['btnText']) && isset($result['alias']) && $result['display']['nav'] === true) {
							?>
									<div class="btn">
										<div class="btn__container">
											<div class="btn__wrapper">
												<a class="btn__link" href="/<?= $result['alias'] ?>" title="<?= $result['btnTitle'] ?>"><?= $result['btnText']  ?></a>
											</div>
										</div>
									</div>
							<?php
								}
							}
							?>
						</div>
					</div>
				</div>

			</nav>
<?php
		}
	}
}
?>