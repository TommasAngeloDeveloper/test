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
		$url_array = \layout\Controller::return_property('url_array');
		$url = '/' . $url_array[0] . '/';
?>
		<div class="aside_catalog">
			<div class="container-btn_all">
				<a class="asside__btn_all-link" href="<?= $url ?>">Все товары</a>
			</div>
			<?php
			$list_section = $data['lists']['list_section'];
			if (!empty($list_section) && is_array($list_section)) {
			?>

				<table>
					<tr>
						<th>Разделы</th>
					</tr>
					<?php
					foreach ($list_section as $section) {
						$section['url'] = preg_replace('/[^ a-zа-яё_\d]/ui', '', $section['url']);
					?>
						<tr>
							<td>
								<a class="asside__btn_all-link" href="<?= $url . 'section/' . $section['url']  ?>"> <?= $section['name'] ?></a>
							</td>
						</tr>
					<?php
					}
					?>
				</table>



			<?php
			}
			$list_type = $data['lists']['list_type'];
			if (!empty($list_type) && is_array($list_type)) {
			?>

				<table>
					<tr>
						<th>Тип</th>
					</tr>
					<?php
					foreach ($list_type as $type) {
						$type['url'] = preg_replace('/[^ a-zа-яё_\d]/ui', '', $type['url']);
					?>
						<tr>
							<td>
								<a class="asside__btn_all-link" href="<?= $url . 'type/' . $type['url']  ?>"> <?= $type['name'] ?></a>
							</td>
						</tr>
					<?php
					}
					?>
				</table>

		</div>

	<?php
			}
	?>
	</div>
	<div class="ta_container page">
		<?php

		$list_product = $data['lists']['list_products'];
		if (!empty($list_product) && is_array($list_product)) {
		?>

			<table>
				<caption> Список товаров </caption>
				<tr>
					<th>Название товара</th>
					<th>Артикул</th>
					<th class="th-section">Раздел</th>
					<th class="th-type">Тип</th>
					<?php
					if ($url_array[1] === 'product') { ?>
						<th class="th-price">Цена</th>
						<th class="th-price">Старая цена</th>
						<th class="th-currency">Валюта</th>
						<th>Заметки</th>
						<th>Содержание</th>
						<th class="th-visible">Видимость</th>
					<?php
					} else {
					?>
						<th class="th-btn"></th>
					<?php
					}
					?>

				</tr>
				<?php
				foreach ($list_product as $product) {
				?>
					<tr>
						<td>
							<?= $product['name'] ?>
						</td>
						<td>
							<?= $product['articul'] ?>
						</td>
						<td class="th-section">
							<ol>
								<?php
								foreach ($product['section'] as $result) { ?>
									<li> <?= $result ?> <br></li>
								<?php
								}
								?>
							</ol>
						</td>
						<td class="th-type">
							<ol>
								<?php
								foreach ($product['type'] as $result) { ?>
									<li> <?= $result ?> <br></li>
								<?php
								}
								?>
							</ol>
						</td>
						<?php
						if ($url_array[1] === 'product') { ?>
							<td class="th-price"><?= $product['price'] ?></td>
							<td class="th-price"><?= $product['price_old'] ?></td>
							<td class="th-currency"><?= $product['currency'] ?></td>
							<td><?= $product['notice'] ?></td>
							<td><?= $product['content'] ?></td>
							<td class="th-visible"><?= $product['visible'] ?></th>
							<?php
						} else {
							$product['url'] = preg_replace('/[^ a-zа-яё_\d]/ui', '', $product['url']);
							?>
							<td class="td-btn">
								<a class="td-btn-link" href="<?= $url . 'product/' . $product['url']  ?>">Подробнее</a>
							</td>
						<?php
						}
						?>

					</tr>
				<?php
				}
				?>
			</table>

	</div>

<?php

		}
	}
}
