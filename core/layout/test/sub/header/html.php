<?php

namespace header;

class html
{
	public static function return($method_name, $data = null)
	{

		return self::$method_name($data);
	}
	private static function html($data = null)
	{

		$company_info = \company_info::return();

?>


		<header class="header">
			<div class="header-container">
				<div class="header-wrapper">
					<div class="ta_container">

						<div class="block__logo">
							<div class="logo-container">
								<div class="logo-wrapper">
									<img class="img" src="/<?= $company_info['logo']['value']['logo']['value'] ?>" alt="">
								</div>
							</div>
						</div>

						<div class="block__company_name">
							<div class="company_name-container">
								<div class="company_name-wrapper">
									<h2 class="text"> <?= $company_info['company_name']['value']['abbreviated']['value'] ?></h2>
								</div>
							</div>
						</div>

						<div class="block__phones">
							<div class="phones-container">
								<div class="phones-wrapper">
									<?php
									foreach ($company_info['phones']['value'] as $value) { ?>
										<div class="phone">
											<div class="phone-container">
												<div class="phone-wrapper">
													<a class="number" href="tel:<?= $value['value'] ?>">
														<?= $value['value'] ?>
													</a>
												</div>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>

						<div class="block__working_hours">
							<div class="working_hours-container">
								<div class="working_hours-wrapper">

									<div class="block__lable">
										<div class="lable-container">
											<div class="lable-wrapper">
												<h2 class="text">
													График работы
												</h2>
											</div>
										</div>
									</div>
									<div class="block__text">
										<div class="text-container">
											<div class="text-wrapper">
												<pre class="text"> <?= $company_info['working_hours']['value']['working_hours']['value'] ?></pre>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="block__adress">
							<div class="adress-container">
								<div class="adress-wrapper">
									<span class="text">
										<?
										$check = 0;
										foreach ($company_info['address']['value'] as $value) {
											if ($value['value'] != null) {
												if ($check !== 0) {
													echo ', ';
												}
												echo $value['value'];
												$check = 1;
											}
										}
										?>
									</span>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

		</header>
<?php

	}
}
?>