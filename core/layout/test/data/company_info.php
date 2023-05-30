<?php

namespace company_info;

class data
{
	private static $_instance = null;
	private  $root = null;
	private  $path = null;
	private   static $company_info = [
		'logo' => [
			'img' => 'Логотип компании',
		],
		'company_name' => [
			'title' => 'Имя компании',
			'name' => '',
		],
	];
	private function __clone()
	{
	}
	private function __wakeup()
	{
	}
	function __construct()
	{
	}

	public static  function getInstance($param)
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
			if (isset($param['root'])  && $param['root'] != null && self::$_instance->root === null) {
				self::$_instance->root = $param['root'];
			}
			if (isset($param['path'])  && $param['path'] != null && self::$_instance->path === null) {
				self::$_instance->path = $param['path'];
				if (isset($param['path']['logo'])) {
					$file_logo = \FoldersAndFiles::file_allFileName($param['path']['logo'], false);
					self::$company_info['logo']['img'] = $param['path']['logo'] . $file_logo;
				}
			}
			self::$_instance->company_info = self::$company_info;
			self::update__company_info();
		}
		return self::$_instance;
	}

	/**
	 * Вернет данные о компании
	 * @param string|array $return_name массив или строка ключей возвращаемого значение
	 * @return array вернет массив со значениями или ошибку
	 */
	public static function return($return_name = null)
	{
		if ($return_name === null) {
			if (isset(self::$_instance->company_info)) {
				return self::$_instance->company_info;
			} else {
				$return = ['error' => 'Данные о компании не существуют'];
			}
		} else {
			if (!is_array($return_name)) {
				$return_name = [$return_name];
			}
			foreach ($return_name as $name) {

				if (is_string($name) &&  isset(self::$_instance->company_info[$name])) {
					$return[$name] = self::$_instance->company_info[$name];
				} else {
					$return = ['error' => 'неверное имя данных компании - ' . $name];
					break;
				}
			}
			return $return;
		}
	}
	/**
	 * Обновление настроек
	 */
	private static function update__company_info($company_info = null)
	{
		if ($company_info === null) {
			$company_info = self::$_instance->company_info;
		}
		if (is_array($company_info)) {
			$root = self::$_instance->root;
			foreach ($company_info as $key => $value) {
				$link = $root . 'company_info/' . $key . '.php';
				$include = \system\functions\sub::include($link);
				if (isset($include['error'])) {
					//new Ex($include['error']);
				} else {
					$class = '\base\\' . $key;
					$result = $class::return_property($key);
					if (isset($result['error'])) {
						//new Ex($result['error']);
					} else {

						foreach ($result[$key] as $update_key => $update_value) {
							if (isset($value['value'][$update_key])) {
								$company_info[$key]['value'][$update_key]['value'] = $update_value;
							}
						}
					}
				}
			}
		}
		self::$_instance->company_info = $company_info;
	}
}
