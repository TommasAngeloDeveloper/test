<?php

namespace layuot\views\catalog\db;

class read
{
	public static function get_product($connect, $url_array)
	{
		if (isset($url_array[1])) {
			$result = self::sort($connect, $url_array);
		} else {
			$result = self::get_sort_all($connect);
		}
		return $result;
	}
	private static function sort($connect, $url_array)
	{
		$class = 'layuot\views\catalog\db\read';
		$method =  'get_sort_' . $url_array[1];
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);

		if (isset($check_ClassAndMethod['error'])) {
			new \Ex($check_ClassAndMethod['error']);
		} else {
			$result = $class::$method($connect, $url_array);
			return $result;
		}
		return null;
	}
	private static function get_sort_all($connect)
	{
		$table_name = 'product';
		$sql = "SELECT `id`,`name`,`url`,`articul` FROM $table_name";
		$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			$result = $result->fetch_all(MYSQLI_ASSOC);
			$result =	self::add_product_sort($connect, $result);
		} else {
			$result = [];
		}
		return $result;
	}
	private static function add_product_sort($connect, $list_product)
	{

		foreach ($list_product as $key => $product) {
			$section_and_type = self::add_section_and_type($connect, $product['id'], 0);
			$list_product[$key] +=  $section_and_type[0];
		}

		return $list_product;
	}
	/**
	 * Добавление к товару его разделы и типы
	 */
	private static function add_section_and_type($connect, $product_id, $key)
	{
		if (!is_array($product_id)) {
			$product_id = $product_id;
		}
		$table_name_assignment = 'product_assignment';
		$table_name_section = 'product_section';
		$table_name_type = 'product_type';
		$colum_name = 'product_id';
		$sql = "SELECT `section_id`,`type_id` FROM $table_name_assignment WHERE $colum_name='$product_id'";
		$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			$result = $result->fetch_all(MYSQLI_ASSOC);
			$list_product[$key]['section'] = [];
			$list_product[$key]['type'] = [];
			foreach ($result as $result_sort) {
				if (!isset($list_product[$key]['section'][$result_sort['section_id']])) {
					$section_id = $result_sort['section_id'];
					$colum_name = 'id';
					$sql = "SELECT `name` FROM $table_name_section WHERE $colum_name='$section_id'";
					$result = $connect->query($sql);
					if ($result->num_rows > 0) {
						$result = $result->fetch_all(MYSQLI_ASSOC);
						$list_product[$key]['section'][$result_sort['section_id']] = $result[0]['name'];
					}
				}
				if (!isset($list_product[$key]['type'][$result_sort['type_id']])) {
					$type_id = $result_sort['type_id'];
					$colum_name = 'id';
					$sql = "SELECT `name` FROM $table_name_type WHERE $colum_name='$type_id'";
					$result = $connect->query($sql);
					if ($result->num_rows > 0) {
						$result = $result->fetch_all(MYSQLI_ASSOC);
						$list_product[$key]['type'][$result_sort['type_id']] = $result[0]['name'];
					}
				}
			}
		}
		return $list_product;
	}
	/**
	 * Сортировка товара (Выбор одного товара)
	 */
	private static function get_sort_product($connect, $url_array)
	{
		$table_name = 'product';
		$product = $url_array[2];
		$sql = "SELECT * FROM $table_name WHERE `url`='$product'";
		$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			$result = $result->fetch_all(MYSQLI_ASSOC);
			$section_and_type = self::add_section_and_type($connect, $result[0]['id'], 0);
			$result[0] += $section_and_type[0];
		}
		//	print_array_1($result[0]);
		return $result;
	}

	private static function get_sort_section($connect, $url_array)
	{

		return self::get_sort($connect, $url_array);
	}
	private static function get_sort_type($connect, $url_array)
	{
		return self::get_sort($connect, $url_array);
	}
	/**
	 * Сортировка товаров
	 */
	private static function get_sort($connect, $url_array)
	{
		$table_name = 'product_' . $url_array[1];
		$sort_by = $url_array[2];
		$sql = "SELECT id FROM $table_name WHERE `url`='$sort_by'";
		$result = $connect->query($sql);
		$colum_name = $url_array[1] . '_id';
		if ($result->num_rows > 0) {
			$id = $result->fetch_row();
			$id = $id[0];
			$table_name = 'product_assignment';
			$sql = "SELECT product_id FROM $table_name WHERE $colum_name='$id'";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				$result = $result->fetch_all();
				$return = self::select_product($connect, $result);
				return $return;
			}
		}
		return null;
	}
	/**
	 * Добавляем к сортированным товарам их разделы и типы
	 */
	private static function select_product($connect, $array_product_id = [])
	{
		if (!empty($array_product_id)) {
			$return = [];
			foreach ($array_product_id as $product_id) {
				if (!isset($return[$product_id[0]])) {
					$product_id = $product_id[0];
					$return[$product_id] = [];
					$sql = "SELECT `id`,`name`,`articul`,`url` FROM `product` WHERE `id`='$product_id'";
					$result = $connect->query($sql);
					if ($result->num_rows > 0) {
						$result = $result->fetch_all(MYSQLI_ASSOC);
						$return[$product_id] = $result[0];
						$add_section_and_type = self::add_section_and_type($connect,	$product_id, 0);
						$return[$product_id] = array_merge($return[$product_id], $add_section_and_type[0]);
					}
				}
			}
		}
		return $return;
	}
}
