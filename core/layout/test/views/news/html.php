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
		// Проверяем номер страницы
		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
			$number_page = $_GET['page'];
		} else {
			$number_page = '1';
		}
		$_SESSION['url_last'] = url_now(2);
		$news = \layuot\db\read::return('get_news', $number_page); // Списк новостей
		$path_img = \layout\Controller::return_property('root') . 'res/img/';
		$routes = \layout\routes::return_property('routes');
?>
		<div class="page">
			<div class="ta_container">
				<div class="block_news">
					<div class="block_news-container">
						<div class="block_news-wrapper">

							<div class="block-title_page">
								<div class="title_page">
									<div class="title_page-container">
										<div class="title_page-wrapper">
											<div class="title_page-text">
												Новости
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="block-items">
								<?php self::news_item($news['news'], $path_img,	$routes); ?>
							</div>
							<?php

							self::block_count_pages($news['count_pages'], $path_img);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	/**
	 * Блок с новостями
	 */
	private static function news_item($news, $path_img,	$routes)
	{

		foreach ($news as $result) {
			$date = $result['idate'];
		?>
			<div class="block-news_item">
				<div class="news_item">
					<div class="news_item-container">
						<div class="news_item-wrapper">
							<div class="item_date">
								<div class="item_date-container">
									<div class="item_date-wrapper">
										<div class="item_date-text">
											<?= date("d.m.Y", $date); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="item_title">
								<div class="item_title-container">
									<div class="item_title-wrapper">
										<div class="item_title-text">
											<?= $result['title'] ?>
										</div>
									</div>
								</div>
							</div>
							<div class="item_announce">
								<div class="item_announce-container">
									<div class="item_announce-wrapper">
										<div class="item_announce-text">
											<?= $result['announce'] ?>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="item_link">
					<div class="item_link-container">
						<a class="item_link-wrapper" href="<?= $routes['routes']['news_article']['alias'] . '/' . $result['id'] ?>">
							<div class="item_link-text">
								Подробнее
							</div>
							<img class="arrow arrow_img-svg" src="<?= $path_img . 'arrow/Arrow_2.svg' ?>" alt="">
						</a>
					</div>
				</div>
			</div>
		<?php
		}
	}
	/**
	 * Блок постраничной навигации
	 */
	private static function block_count_pages($count_pages, $path_img)
	{
		if (is_numeric($count_pages)) {
		?>
			<div class="block-count_pages">
				<div class="count_pages">
					<div class="count_pages-container">
						<div class="count_pages-wrapper">
							<?php
							for ($number = 1; $number <= $count_pages; $number++) {

								if (isset($_GET['page']) && is_numeric($_GET['page'])) {

									$number_page = $_GET['page'];
									$number_page_next = 		$number_page + 1;
									$number_page_back =  $number_page - 1;
									if ($number == $number_page_back || $number == $number_page_next || $number == $number_page || $number == $count_pages || $number == 1) {
									} else {
										continue;
									}


									/******************* */
									if (is_numeric($number_page)) {
										if ($number_page > 0 &&  $number_page == $number) {
											$css = 'background-color:#841844;color:white;';
										} else {
											if ($number_page > $count_pages && $number == $count_pages) {
												$css = 'background-color:#841844;color:white;';
											} else {
												$css = '';
											}
										}
									} else {
										if ($number == 1) {
											$css = 'background-color:#841844;color:white;';
											$_GET['page'] = 1;
										} else {
											$css = '';
										}
									}
								} else {
									if ($number == 1) {
										$css = 'background-color:#841844;color:white;';
										$_GET['page'] = 1;
									} else {
										$css = '';
									}
								}

							?>
								<div class="number">
									<a class="number-container" href="?page=<?= $number ?>" style="<?= $css ?>">
										<div class="number-wrapper">
											<div class="number-text">
												<?= $number ?>
											</div>
										</div>
									</a>
								</div>
							<?php
							}
							if (isset($_GET['page'])) {
								if (is_numeric($_GET['page'])) {
									$number = $number - 1;
									$number_page = $_GET['page'];
									if ($number_page > 0 &&  $number_page < $number) {
										self::block_btn_nextPage($path_img);
									}
								}
							}
							?>

						</div>
					</div>
				</div>
			</div>

		<?php
		}
	}
	private static function block_btn_nextPage($path_img)
	{
		if (isset($_GET['page'])) {
			$number_page = $_GET['page'] + 1;
			$url = '?page=' . $number_page;
		} else {
			$url = '?page=2';
		}
		?>
		<div class="arrow">
			<a class="arrow-container" href="<?= $url ?>">
				<div class="arrow-wrapper">
					<div class="arrow-text">
						<img class="arrow-img arrow_img-svg" src="<?= $path_img . 'arrow/Arrow_2.svg' ?>" alt="">
					</div>
				</div>
			</a>
		</div>
<?
	}
}
?>