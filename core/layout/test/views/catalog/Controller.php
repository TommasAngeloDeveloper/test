<?php

namespace view;

class Controller
{
	use \traits\Singleton_Controller;

	private static function html($data)
	{

		$link = 'html.php';
		if (!@include_once($link)) {
			new \Ex(\ExDetailsText::include($link), 'view', 12);
		} else {
			// подключаемся к Базе данных
			$connect = self::getConnect();
			if (!is_object($connect) && isset($connect['error'])) {
				new \Ex($connect['error'], 'page', 0);
			} else {
				$list_type = 	self::get_all($connect, 'product_type');
				$list_section = 	self::get_all($connect, 'product_section');

				$list_products =	self::router($connect);
				$data = [
					'lists' => [
						'list_products' => $list_products,
						'list_type' => $list_type,
						'list_section' => $list_section
					]
				];
				return html::return('html', $data);
			}
		}
	}
	private static function getConnect()
	{
		include_once('db/connect.php');
		$connect = \layout\views\catalog\DB::getConnect();
		return $connect;
	}
	/**
	 * Получить список всего
	 * @param mixed $connect Подключение
	 * @param string $table_name Имя таблицы
	 * @return array Вернет результат выполнения метода
	 */
	private static function get_all($connect, $table_name)
	{
		$sql = "SELECT * FROM $table_name";
		$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			$result = $result->fetch_all(MYSQLI_ASSOC);
		} else {
			$result = [];
		}
		return $result;
	}
	private static function router($connect)
	{
		$url_array = \layout\Controller::return_property('url_array');
		$root = \layout\Controller::return_property('root') . 'views/' . $url_array[0] . '/';
		$link = $root . 'db/read.php';
		include_once($link);
		$class = 'layuot\views\catalog\db\read';
		$method =  'get_product';
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);

		if (isset($check_ClassAndMethod['error'])) {
			new \Ex($check_ClassAndMethod['error']);
		} else {

			$result =  $class::$method($connect, $url_array);
			return $result;
		}
	}
}
