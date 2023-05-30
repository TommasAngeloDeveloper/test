<?php

namespace layuot\db;

class read
{
	private static $connect = null;
	/**
	 * Вернуть результат выполнения нужного метода
	 * @param string $method_name имя метода
	 */
	public static function return($method_name, $param = null)
	{
		$result = null;
		self::$connect = \layout\DB::getConnect();
		if (!is_object(self::$connect) && isset(self::$connect['error'])) {
			new \Ex(self::$connect['error'], 'page', 0);
		} else {
			$class = get_class();
			$check = method_exists($class, $method_name);
			if ($check !== true) {
				new \Ex('no method - ' . $method_name, 'page', 02);
			} else {
				$result = self::$method_name($param);
			}
		}
		return $result;
	}
	/**
	 * Получить все новости
	 */
	private static function get_news($number_page)
	{

		$connect = self::$connect;
		$news__linit_page = 5; // Количество выводимых новостей на странице
		$count_pages = self::get_nes__count_pages($news__linit_page); // Подсчитывем колчисетво страниц
		if (!is_numeric($number_page)) {
			$number_page = 1;
		} else if ($number_page < 1) {
			$number_page = 1;
		} else if ($number_page > $count_pages) {
			$number_page = $count_pages;
		}
		$news__number_page = $number_page; // Номер страницы
		$news__select = $news__linit_page * $news__number_page - 	$news__linit_page; // Подсчитываем с какой строки делать выборку
		$table_name = 'news';
		$sql = $sql = "SELECT `id`,`idate`,`title`,`announce` FROM $table_name  ORDER BY `idate` DESC LIMIT 	$news__select,$news__linit_page";
		$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			$return['news'] = $result->fetch_all(MYSQLI_ASSOC);
			$return['count_pages'] = self::get_nes__count_pages($news__linit_page); // Подсчитывем колчисетво страниц
		} else {
			$result = null;
		}
		return $return;
	}
	/**
	 * Посчитать количество страниц
	 */
	private static function get_nes__count_pages($news__linit_page)
	{
		$connect = self::$connect;
		$table_name = 'news';
		$sql = "SELECT count(*) FROM $table_name ";
		$result =  $connect->query($sql);
		if ($result->num_rows > 0) {
			$result = $result->fetch_row();
			$result = ceil($result[0] / $news__linit_page);
			$return = $result;
		} else {
			$return = null;
		}
		return $return;
	}
	/**
	 * Получить новость по id
	 */
	private static function get_work_news($id_news)
	{
		$return = null;
		if (is_numeric($id_news)) {
			$connect = self::$connect;
			$table_name = 'news';
			$sql = "SELECT * FROM $table_name WHERE `id`='$id_news'";
			$result =  $connect->query($sql);
			if ($result->num_rows > 0) {
				$result = $result->fetch_assoc();
				$return = $result;
			}
		} else {
			redirect_page();
		}
		return $return;
	}
	/**************************************************************************************************** */
}
