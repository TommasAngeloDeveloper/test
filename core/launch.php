<?php

namespace core;

use Ex;

class launch
{
	private static $routes = [];
	private static $controllers = [];
	private const controllers_base = [
		'root' => 'core/base/',
		'link' => 'Controller.php',
		'class' =>  'Controller',
		'namespace' => 'base\\',
	];
	private static  $settings = [
		'title_page' => [
			'status' => true,
			'value' => null
		],
		'mobile' => false,
		'routes' => [],	// Список маршрутов	
		'html' => [
			'_html' => [
				'link' => null
			],
			'meta' => [
				'Controller' => [],
				'data' => [
					'mobile' => false,
					'title' => [
						'value' => null
					],
					'title_prefix' => [
						'status' => true,
						'value' => null
					],
					'description' => [
						'value' => null
					],
					'keywords' => [
						'value' => null
					],
					'favico' => null,
					'css' => [],
					'js' => [],
				],
			],
		],
		'add' => [],
	];

	public static function launch()
	{
		$class = get_class();
		/* Запускаем Базовый контроллер */
		$method =  'include_Base';
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
		if (isset($check_ClassAndMethod['error'])) {
			new Ex($check_ClassAndMethod['error']);
		} else {
			$class::$method();
		}
		/* Запускаем  Контроллер Шаблона */
		$method =  'include_Layout';
		$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
		if (isset($check_ClassAndMethod['error'])) {
			new Ex($check_ClassAndMethod['error']);
		} else {
			$class::$method();
		}
		return self::$settings;
	}



	/****************************************************************************************/
	/* Запускаем Базовый контроллер */
	/****************************************************************************************/
	private static function include_Base()
	{
		$root =  'core/base/';
		$link  = $root . 'Controller.php';
		$include = \system\functions\sub::include($link);
		if (isset($include['error'])) {
			new Ex($include['error']);
		} else {
			$namespace = self::controllers_base['namespace'];
			$class = 	$namespace  . self::controllers_base['class'];
			$method = 'return';
			// Получаем дата данные
			$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
			if (isset($check_ClassAndMethod['error'])) {
				new Ex($check_ClassAndMethod['error']);
			} else {
				$result = $class::$method(['root' => $root, 'return' => [
					'return_Data' => [
						'data' => ['link', 'path'],
						'settings' => ['routes'],
						'config' => ['config'],
					]
				]]);
				if (isset($result['error'])) {
					new \Ex($result['error']);
				} else {
					// Добавляем в список css файл
					self::add_css($result['link']['css']);
					// Добавляем в список js файл
					self::add_js($result['link']['js']);
					// Заменяем  мета данные
					//		self::$settings['html']['meta']['data'] = \ta\sub::add_array_by_key(self::$settings['html']['meta']['data'], $return['config']['meta']);
					// Добавляем путь до html meta
					self::$settings['html']['meta']['Controller']['link'] = $result['link']['meta'];
					// Добавляем класс meta
					self::$settings['html']['meta']['Controller']['class'] = 'core\base\meta';
					// Добавляем имя макета
					self::$settings['layout']['name'] = $result['config']['layout_name'];
					// добавляем маршруты
					self::$routes = $result['routes'];
					// Добавляем контроллер макета
					self::$controllers['layout'] = [
						'root' => 'core/layout/' . $result['config']['layout_name'] . '/',
						'class' => 'layout\Controller',
					];
				}
			}
		}
	}

	/****************************************************************************************/
	/* Запускаем  Контроллер Шаблона */
	/****************************************************************************************/

	private static function include_Layout()
	{
		$root =  self::$controllers['layout']['root'];
		$link  = $root . 'Controller.php';
		$include = \system\functions\sub::include($link);
		if (isset($include['error'])) {
			new Ex($include['error']);
		} else {
			$class =  self::$controllers['layout']['class'];
			$method = 'launch';
			$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
			if (isset($check_ClassAndMethod['error'])) {
				new Ex($check_ClassAndMethod['error']);
			} else {
				$url_array = url_array();
				$result = $class::$method(['root' => $root, 'url_array' => $url_array]);
				if (isset($result['data']['error'])) {
					new \Ex($result['data']['error']);
				} else if (empty($result)) {
					new Ex(\ExDetailsText::empty('settings'));
				} else {

					// Заменяем  мета данные
					self::$settings['html']['meta']['data'] = \system\functions\sub::add_array_by_key(self::$settings['html']['meta']['data'], $result['html']['meta']['data']);
					// добавляем html разметку
					self::$settings['html']['_html'] = $result['html']['_html'];
					// добавляем данные вида
					self::$settings['html']['view'] =   $result['html']['view'];
					// Добавляем в список css файл
					self::add_css($result['html']['meta']['css']);
					// Добавляем в список js файл
					self::add_js($result['html']['meta']['js']);
					if (!empty($result['html']['sub'])) {
						foreach ($result['html']['sub'] as $sub_name => $value) {
							self::$settings['html'][$sub_name] = $value;
						}
					}
					// Добавляем контент страницы
					if (isset($result['html']['view']['content'])) {
						$content = $result['html']['view']['content'];
					} else {
						$content = null;
					}
					self::$settings['html']['view']['content'] = $content;
				}
			}
		}
	}

	/****************************************************************************************/
	/* Добавляем в список css файл */
	/****************************************************************************************/
	private static function add_css($css)
	{
		// Список файлов для копирования и переноса css файлов
		\system\functions\sub::transfer_css($css);
		// добавляем файлы css
		$css = \system\functions\sub::add_css(self::$settings['html']['meta']['data']['css'], $css);
		if ($css) {
			self::$settings['html']['meta']['data']['css'] = $css;
		}
	}

	/****************************************************************************************/
	/* Добавляем в список js файл */
	/****************************************************************************************/
	private static function add_js($js)
	{
		self::$settings['html']['meta']['data']['js'] = \system\functions\sub::add_js(self::$settings['html']['meta']['data']['js'], $js);
	}
}
