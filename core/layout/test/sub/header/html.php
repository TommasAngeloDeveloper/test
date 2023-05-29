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

		$class = 'company_info\data';
		$method = 'return';
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
		if (!isset($check_ClassAndMethod['error'])) {
			$company_info = $class::$method();
?>


			<header class="header">
				<div class="header-container">
					<div class="header-wrapper">
						<div class="ta_container">

							<div class="block__logo">
								<div class="logo-container">
									<a class="logo-wrapper" href="/">
										<img class="img" src="/<?= $company_info['logo']['img'] ?>" alt="">
									</a>
								</div>
							</div>

							<div class="block__company_name">
								<div class="company_name-container">
									<a class="company_name-wrapper" href="/">
										<h2 class="text"> <?= $company_info['company_name']['name'] ?></h2>
									</a>
								</div>
							</div>
							<?php if (isset($company_info['phones']['value'])) { ?>
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
							<?php }
							if (isset($company_info['working_hours']['value'])) {
							?>
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
							<?php }
							if (isset($company_info['address']['value'])) {
							?>
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
							<?php } ?>
						</div>
					</div>
				</div>

			</header>
<?php
		}
	}
}
?>