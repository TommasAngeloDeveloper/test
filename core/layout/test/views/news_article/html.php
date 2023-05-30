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
		$routes = \layout\routes::return_property('routes');
		// Проверяем номер страницы
		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
			$number_page = $_GET['page'];
		} else {
			$number_page = '1';
		}
		$news = $data['content']; // Списк новостей
		$date = $news['idate'];
		$path_img = \layout\Controller::return_property('root') . 'res/img/';
		if (isset($_SESSION['url_last'])) {
			$url_back =  $_SESSION['url_last'];
			unset($_SESSION['url_last']);
		} else {
			$url_back = '/' . $routes['routes']['news']['alias'];
		}
?>
		<div class="page">
			<div class="ta_container">
				<div class="block_news">
					<div class="block-page_nav">
						<div class="page_nav-container">
							<div class="page_nav-wrapper">
								<a class="page_nav-link" href="/">Главная </a><span class="separator"> / </span> <a class="page_nav-link" href="/<?= $routes['routes']['news']['alias'] ?>"><?= $routes['routes']['news']['btnText'] ?></a><span class="separator"> / </span><span><?= $news['title'] ?></span>
							</div>
						</div>
					</div>
					<div class="block_news-container">
						<div class="block_news-wrapper">

							<div class="block-title_page">
								<div class="title_page">
									<div class="title_page-container">
										<div class="title_page-wrapper">
											<div class="title_page-text">
												<?= $news['title'] ?>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="item">
								<div class="block-date">
									<div class="date-container">
										<div class="date-wrapper">
											<div class="date-text">
												<?= date("d.m.Y", $date); ?>
											</div>
										</div>
									</div>
								</div>
								<div class="block-item_news">
									<div class="block-item_announce">
										<div class="item_announce-container">
											<div class="item_announce-wrapper">
												<div class="item_announce-text">
													<?= $news['announce'] ?>
												</div>
											</div>
										</div>
									</div>
									<div class="block-item_content">
										<div class="item_content-container">
											<div class="item_content-wrapper">
												<div class="item_content-text">
													<?= $news['content'] ?>
												</div>
											</div>
										</div>
									</div>
									<div class="block-btn_back">
										<div class="btn_back-container">
											<a class="btn_back-wrapper" href="<?= $url_back ?>">
												<img class=" arrow_img-svg" src="/<?= $path_img . 'arrow/Arrow_2.svg' ?>" alt="">
												<div class="btn_back-text">
													Назад к новостям
												</div>
											</a>
										</div>

									</div>
								</div>



							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		</div>
<?php
	}
}
?>