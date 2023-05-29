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
?>
		<div class="page">
			<?php self::block_last_news($news['news_last'], $path_img) ?>
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
								<?php self::news_item($news['news'], $path_img); ?>
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
	private static function block_last_news($last_news, $path_img)
	{
		$img = $path_img . 'news/' . $last_news['image'];
	?>
		<div class="block-last_news">
			<div class="last_news">
				<div class="last_news-container" style="background-image:url(<?= '/' . $img ?>);">
					<div class="last_news-wrapper ">

						<a class="block_news-text ta_container" href="work_news/<?= $last_news['id'] ?>" title="Подробнее">

							<div class="last_news_title">
								<div class="last_news_title-container">
									<div class="last_news_title-wrapper">
										<div class="last_news_title-text">
											<?= $last_news['title'] ?>
										</div>
									</div>
								</div>
							</div>

							<div class="last_news_announce">
								<div class="last_news_announce-container">
									<div class="last_news_announce-wrapper">
										<div class="last_news_announce-text">
											<?= $last_news['announce'] ?>
										</div>
									</div>
								</div>
							</div>
						</a>

					</div>
				</div>
			</div>
		</div>
		<?php
	}
	/**
	 * Блок с новостями
	 */
	private static function news_item($news, $path_img)
	{

		foreach ($news as $result) {
			$date = date_create($result['date']);
		?>
			<div class="block-news_item">
				<div class="news_item">
					<div class="news_item-container">
						<div class="news_item-wrapper">
							<div class="item_date">
								<div class="item_date-container">
									<div class="item_date-wrapper">
										<div class="item_date-text">
											<?= date_format($date, "d.m.Y"); ?>
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
						<a class="item_link-wrapper" href="work_news/<?= $result['id'] ?>">
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
								if (isset($_GET['page'])) {
									$number_page = $_GET['page'];
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