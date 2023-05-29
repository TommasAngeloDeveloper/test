<?php

/********************************************************************/
/* Работа с папками + файлами */
/********************************************************************/
class  FoldersAndFiles
{
	/********************************************************************/
	/* папки + файлы */
	/********************************************************************/

	/** 
	 *  Вернёт массив имен файлов и папок из указанной директории
	 * (содержащиеся директории будут проигнорированы)
	 * @param string $dir  путь к директории
	 * @param bool $file  добавить файлы (true / false)
	 * @return array|false Вернет массив имен папок (файлов) или false
	 * */
	public static	function folder_ListFolders($dir, $file = false)
	{
		if (file_exists($dir)) {
			$result = array();
			$cdir = scandir($dir);
			foreach ($cdir as $value) {
				// если это "не точки" 
				if (!in_array($value, array(".", ".."))) {
					if ($file === false) {
						if (is_dir($dir . $value)) {
							$result[] = $value;
						}
					} else {
						$result[] = $value;
					}
				}
			}
			return $result;
		} else {
			return false;
		}
	}
	/* Получаем полный путь ко всем папкам в директории и имена файлов в них */
	public static function path_and_name($dir, $recursive = true)
	{
		/**
		 * @param  string $dir             Путь до папки (на конце со слэшем или без).
		 * @param  bool   $recursive       Включить вложенные папки или нет?
		 */
		if (!is_dir($dir))
			return array();
		$files = array();
		$dir = rtrim($dir, '/\\'); // удалим слэш на конце
		foreach (glob("$dir/{,.}[!.,!..]*", GLOB_BRACE) as $file) {
			if (is_dir($file)) {
				if ($recursive === true) {
					$files = array_merge($files, call_user_func(__METHOD__, $file, $recursive));
				}
			} else {
				$files[] = $file;
			}
		}
		return $files;
	}

	// Переименование файла или папки
	public static function rename($path, $old_name, $new_name)
	{
		if (file_exists($path  . $old_name) && !file_exists($path . $new_name)) {
			echo $path . $new_name;
		}
	}

	// Проверяет искомое имя файла или папки в директории
	public static function check_dir($dir, $checkName)
	{
		$array_FilesAndFolder = FoldersAndFiles::folder_ListFolders($dir);
		if (in_array($checkName, $array_FilesAndFolder)) {
			return true;
		} else {
			return false;
		}
	}
	// Удалить директорию со всем содержимым
	public static function remove_dir($dir)
	{
		if ($objs = glob($dir . '/*')) {
			foreach ($objs as $obj) {
				is_dir($obj) ? FoldersAndFiles::remove_dir($obj) : unlink($obj);
			}
		}
		rmdir($dir);
	}
	/**
	 * Удалить содержимое директории
	 * @param string $path Путь до папки из которой удаляем
	 * @param bool $del_folder Удалить саму папку?
	 * @return bool
	 */
	public static function clear_dir($path, $del_folder = false)
	{
		if (is_string($path)) {
			if ($objs = glob($path . '/*')) {
				foreach ($objs as $obj) {
					is_dir($obj) ? FoldersAndFiles::clear_dir($obj, true) : unlink($obj);
				}
			}
			if ($del_folder) {
				rmdir($path);
			}
		} else {
			return false;
		}
	}

	// Копирует папку со всем содержимым
	public static function copy_dir($dir_copy, $dir_new)
	{
		$dir = opendir($dir_copy);

		if (!is_dir($dir_new)) {
			mkdir($dir_new, 0777, true);
		}

		while (false !== ($file = readdir($dir))) {
			if ($file != '.' && $file != '..') {
				if (is_dir($dir_copy . '/' . $file)) {
					FoldersAndFiles::copy_dir($dir_copy . '/' . $file, $dir_new . '/' . $file);
				} else {
					copy($dir_copy . '/' . $file, $dir_new . '/' . $file);
				}
			}
		}

		closedir($dir);
	}
	/********************************************************************/
	/* папки */
	/********************************************************************/
	/**
	 * Создание каталога
	 * @param string|array $catalog путь создания каталога
	 * @return bool true / false
	 */
	public static function add_Catalog($catalog)
	{

		if (!is_array($catalog)) {
			$catalogs = [$catalog];
		} else {
			$catalogs = $catalog;
		}
		foreach ($catalogs as $new_catalog) {

			if ($new_catalog !== '') {

				$new_catalog = $_SERVER['DOCUMENT_ROOT'] . '/' . $new_catalog;
				if (!file_exists($new_catalog)) {

					if (mkdir($new_catalog, 0777, True)) {
						$result = true;
					} else {
						$result = false;
						break;
					}
				} else {
					$result = true;
				}
			} else {
				$result = false;
				break;
			}
		}
		return $result;
	}

	/********************************************************************/
	/* файлы */
	/********************************************************************/

	/**
	 * Загрузка файла
	 * @param string $path Путь куда загружаем
	 * @param array $file Массив с данным файла
	 * @param array $allowed_exceptions Доступные расширения загружаемого файла
	 * @param string $new_name Новое имя файла для записи (без расширения)
	 * @param bool $rewrite Удалить старый файл?
	 * @return null|string|array Вернет null если загружаем пустой файл, строку с ссылкой на файл или массив с ошибкой
	 */
	public static function upload_file($path, $file, $allowed_exceptions, $new_name, $rewrite)
	{
		if (empty($file['type']) || empty($file['name']) || empty($file['tmp_name'])) {
			return null;
		} else {
			if (!is_string($new_name)) {
				$return = ['error' => 'Некоректный формат параметра $new_name - ' . $new_name];
			} else {
				// Проверяем расширение загружаемого файла на допустимое
				$file_name = $file['name'];
				$validate__exception = self::validate__exception($file_name, $allowed_exceptions);
				if ($validate__exception === false) {
					$return = ['error' => 'Недопустимый формат загружаемых файлов'];
				} else {
					if ($file['error'] != 0) {
						$return = ['error' => 'Возможная атака с помощью файловой загрузки!'];
					} else {
						$name = $new_name . '.' . $validate__exception;
						$link = $path . $name;

						if (!is_dir($path)) {

							$add_Catalog =	self::add_Catalog($path);
							if (!$add_Catalog) {
								$return = ['error' => 'Ошибка создания каталога - ' . $path];
								return $return;
							}
						}
						$check__file_name = self::validate__file_name($path, $new_name);

						if ($check__file_name === null) { // Если не коректны данные для проверки
							return ['error' => 'Некоректные данные проверки имени файла на совпадение - $path = ' . $path . ' , $file_name = ' . $new_name];
						} else if (is_string($check__file_name) && $rewrite === true) { // Если есть совпадение имен и перезапись разрешена - удаляем похожий файл
							self::delite_file($check__file_name);
						} else if (is_string($check__file_name) && $rewrite === false) { // Если есть совпадение имен и перезапись запрещена - записываем ошибку и выходим
							return ['error' => 'Файл с похожим именем уже существует и перезапись запрещена. Старый файл - ' . $check__file_name . '. Новый файл -' . $link];
						}
						if (!move_uploaded_file($file['tmp_name'], $link)) {
							$return = ['error' => 'Ошибка при загрузке файла - ' .  $link];
						} else {
							$return = 	$link;
						}
					}
				}
			}
		}
		return $return;
	}

	/**
	 *  Вернёт многомерный массив, содержащий имена файлов из указанной директории 
	 * (содержащиеся директории будут проигнорированы) и размер
	 * @param string $dir
	 */
	public static function file_NameAndSize($dir)
	{
		$result = array();
		$cdir = scandir($dir);
		$i = 0;
		foreach ($cdir as $value) {
			// если это "не точки" и не директория
			if (!in_array($value, array(".", "..")) && !is_dir($dir . $value)) {
				$result[$i]['file'] = $value;
				$result[$i]['size'] = filesize($dir . DIRECTORY_SEPARATOR . $value);
				$i++;
			}
		}
		return $result;
	}
	/**
	 *  Вернёт массив, содержащий имена файлов из указанной директории 
	 * (содержащиеся директории будут проигнорированы)
	 * @param string $dir сканируемая директория
	 * @param bool $flag Вернуть массив илт строку первого файла
	 * @return array
	 */
	public static function file_Name($dir, $flag = true)
	{
		if (is_dir($dir)) {
			$return = [];
			$cdir = scandir($dir);
			foreach ($cdir as $value) {
				// если это "не точки" и не директория
				if (!in_array($value, array(".", "..")) && !is_dir($dir . $value)) {
					array_push($return, $value);
				}
			}
			if ($flag === false) {
				if (isset($return[0])) {
					$return = $return[0];
				} else {
					$return = null;
				}
			}
		}
		return $return;
	}

	// Перенос файлов
	public static function transferFiles($file_name, $old_folder, $new_folder)
	{
		// Если файл существует, то переносим с удалением
		if (FoldersAndFiles::check_file($old_folder . $file_name)) {
			rename($old_folder . $file_name, $new_folder . $file_name);
		}
	}

	/**
	 * Проверяет на совпадения имен файла по указанному пути (с любым расширением)
	 * @param string $path Путь к директории в которой ищем
	 * @param string $file_name Имя файла которое сравниваем (без расширения)
	 * @return null|false|string Вернет null если данные не коректы, false если похожих файлов нет или ссылку на файл с таким же именем
	 */
	public static function validate__file_name($path, $file_name)
	{
		$return = null;

		if (is_string($file_name)) {
			$dir__files = self::file_Name($path);

			if (empty($dir__files)) {
				$return = false;
			} else {
				foreach ($dir__files as $dir__file_name) {

					$link = $path . $dir__file_name;
					$result = self::file_Info($link, 'filename');
					if ($result === $file_name) {
						$return = $link;
						break;
					} else {
						$return = false;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Удаляет файл по ссылке
	 * @param string $link ссылка к файлу
	 * @return bool true / false
	 */
	public static function delite_file($link)
	{
		$return = false;
		if (is_string($link) && file_exists($link)) {
			$return	= unlink($link);
		}
		return $return;
	}
	// Имена всех файлов в папке
	// @param $array - true/false * Вернуть массив или первый попавшийся файл
	public static function file_allFileName($dir, $array = true)
	{
		$new_array = [];
		if (is_dir($dir)) {
			$array_all = scandir($dir);
			$array_all = array_diff($array_all, [".", ".."]);
			foreach ($array_all as $result) {
				if (!is_dir($dir . $result)) {
					if ($array == true) {
						array_push($new_array, $result);
					} else {
						$new_array = $result;
						break;
					}
				}
			}

			return $new_array;
		}
	}

	// Проверяем наличие файла
	public static function check_file($link)
	{
		if (isset($link) && $link !== '') {
			if (file_exists($link) && !is_dir($link)) {
				return true;
			}
		}
		return false;
	}
	/**
	 * Возвращает информацию о файле
	 * @param string $link ссылка файла
	 * @param string $flag устанавливает какойц тип данных вернуть
	 * + filename - имя файла без расширения
	 * + extension - расширение файла
	 * + dirname - путь к файлу
	 * + basename - имя файла с расширением
	 * @return array|string вернет массив или строку с установленным параметром
	 */
	public static function file_Info($link, $flag = false)
	{
		if ($flag == 'filename') {
			$result = pathinfo($link, PATHINFO_FILENAME);
		} elseif ($flag == 'extension') {
			$result = pathinfo($link, PATHINFO_EXTENSION);
		} elseif ($flag == 'dirname') {
			$result = pathinfo($link, PATHINFO_DIRNAME);
			$result['dirname'] =	$result['dirname'] . '/';
		} elseif ($flag == 'basename') {
			$result = pathinfo($link, PATHINFO_BASENAME);
		} else {
			$result = pathinfo($link);
			$result['dirname'] =	$result['dirname'] . '/';
		}
		return $result;
	}
	/**
	 *  Создает файл с перезаписью содержимого
	 * @param string $path Путь до перезаписываемого файла
	 * @param string $file_name Имя файла в который перезаписываем
	 * @param string $content Записываемый контент
	 * @return bool вернет true / false
	 */
	public static function create_File($path, $file_name, $content)
	{
		if (is_dir($path)) {
			$link = $path . $file_name;
			file_put_contents($link, $content);
			return true;
		} else {
			return false;
		}
	}
	/*	Проверка размера файла  */
	public static function file_ValidateSize($file_size, $max_size, $key)
	{
		if ($key == 'kb' || $key == 'KB') {
			$file_size = $file_size / (1024);
		} elseif (
			$key == 'mb' || $key == 'MB'
		) {
			$file_size = $file_size / (1024 * 1024);
		} elseif ($key == 'gb' || $key == 'GB') {
			$file_size = $file_size / (1024 * 1024 * 1024);
		} elseif ($key == 'tb' || $key == 'TB') {
			$file_size = $file_size / (1024 * 1024 * 1024 * 1024);
		}
		if ($file_size > $max_size) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Получить расширение файла
	 * @param string $file_name имя файла
	 * @return false|string вернет false или расширение
	 */
	public static function get__file_exception($file_name)
	{
		$return = false;
		if (is_string($file_name)) {
			$exception_file = new SplFileInfo($file_name);
			$exception_file =	$exception_file->getExtension();
			if (!empty($exception_file)) {
				$return = $exception_file;
			}
		}
		return $return;
	}

	/**
	 * Проверка расрешений файла на допустимые
	 * @param string $file_name Строковое имя проверяемого файла
	 * @param string $allowed_exceptions Массив с допустимыми расширения
	 * @return false|string false / Расширение файла
	 */
	public static function validate__exception($file_name, $allowed_exceptions)
	{
		$return = false;
		if (is_string($file_name) && is_array($allowed_exceptions)) {
			$exception_file = new SplFileInfo($file_name);
			$exception_file =	$exception_file->getExtension();

			if (!empty($exception_file)) {
				if (in_array($exception_file, $allowed_exceptions)) {
					$return = $exception_file;
				}
			}
		}
		return $return;
	}
	/*
	  Вернёт массив, содержащий имена файлов из указанной директории
	  (содержащиеся директории будут проигнорированы)
	 */
	public static	function file_ListNameFiles($dir, $extension = true)
	{
		$result = array();
		$cdir = scandir($dir);
		foreach ($cdir as $value) {
			// если это "не точки" и не директория
			if (
				!in_array($value, array(".", ".."))
				&& !is_dir($dir . DIRECTORY_SEPARATOR . $value)
			) {
				if ($extension) {
					$result[] = $value;
				} else {
					$result[] = self::file_Info($dir . $value, 'filename');
				}
			}
		}

		return $result;
	}


	/*
	  Вернёт многомерный массив, содержащий имена файлов из указанной директории
	  (содержащиеся директории будут проигнорированы)
	  + дополнительные сведения о каждом файле (в частности размер)
	 */
	public static function file_ListFilesAndInfo($dir)
	{
		$result = array();
		$cdir = scandir($dir);
		$i = 0;
		foreach ($cdir as $value) {
			// если это "не точки" и не директория
			if (
				!in_array($value, array(".", ".."))
				&& !is_dir($dir . DIRECTORY_SEPARATOR . $value)
			) {

				$result[$i]['name'] = $value;
				$result[$i]['size'] = filesize($dir . DIRECTORY_SEPARATOR . $value);
				$i++;
			}
		}

		return $result;
	}
}
