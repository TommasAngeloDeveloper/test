<?php

namespace layout\views\catalog;

class DB
{
	/*
	private static $user_name = 'tomma482_servicecenter71';
	private static $password = 'servicecenter71';
	private static $db_name = 'tomma482_servicecenter71';
	*/
	private static $user_name = 'root';
	private static $password = '';
	private static $db_name = 'test';
	private static $servername = 'localhost';
	private static $connect = null;

	private function __construct()
	{
	}
	private function __clone()
	{
	}
	public static function getConnect()
	{

		if (is_null(self::$connect)) {
			self::$connect = @new \mysqli(self::$servername, self::$user_name, self::$password, self::$db_name);
			if (self::$connect->connect_error) {
				$msg = 'Ошибка подключения: ' . self::$connect->connect_error;
				$return = ['error' => $msg];
			} else {
				$return = self::$connect;
			}
		}
		return $return;
	}
	/**
	 * Проверить есть ли таблица с таким именем в БД
	 * @param string $table_name Имя таблицы которое ищем
	 * @return bool
	 */
	public static function search__table_name($table_name)
	{
		$result = \system\functions\TABLE::tableNameSearch(self::$db_name, self::getConnect(), $table_name);
		return $result;
	}
}
