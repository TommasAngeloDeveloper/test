<?php

namespace layout;

use ExDetailsText;

class Controller
{
	private const title = 'TEST';
	private static $url_array = [];
	private static $settings = [
		'basic' => null,
		'view' => null,
		'sub' => []
	];
	use \traits\Singleton_Controller;
	public static function launch($param)
	{
		if (!isset($param['root'])) {
			$param['root'] = null;
		}
		// Добавляем массив url
		self::$url_array = $param['url_array'];
		// Получаем основные дата данные 
		$result__basic = self::return(['root' => $param['root'], 'url_array' => $param['url_array'], 'return' => [
			'return_Data' => [
				'data' => ['link', 'path'],
				'config' => ['config'],
				'routes' => ['routes'],
			]
		]]);

		/*****************************************************************************************************************/

		// подключаем файл с информацие о компании
		$include = \system\functions\sub::include($result__basic['link']['db']['connect']);
		if (isset($include['error'])) {
			new \Ex($include['error']);
		} else {
			$include = \system\functions\sub::include($result__basic['link']['db']['read']);
			if (isset($include['error'])) {
				new \Ex($include['error']);
			}
		}
		/*****************************************************************************************************************/

		if (isset($result__basic['error'])) {
			new \Ex($result__basic['error']);
		} else {
			self::$settings['basic'] = $result__basic;
		}
		// Запускаем роутер и получаем данные вида
		$result__view = self::Router();
		if (isset($result__view['error'])) {
			new \Ex($result__view['error']);
		} else {
			self::$settings['view'] = $result__view;
		}
		$result['basic'] = $result__basic;
		$result['view'] = $result__view;
		$return = [
			'html' => [
				'meta' => [
					'css' => [],
					'js' => [],
				],
				'view' => [
					'class' =>  'view\Controller',
					'method' =>  'return',
					'data' => [],
					'content' => $result__view['view']['content']
				],
			]
		];
		// Сохраняем все данные в общие
		self::$_instance->param = $result;
		self::add_sub();
		// Добавляем мета данные title/description/keywords страницы
		$return['html']['meta']['data'] = $result['view']['config']['meta'];
		// Обновляем мета title
		$return['html']['meta']['data']['title']['value'] =  $result['view']['config']['meta']['title']['value'] . ' - ' . self::title;
		// Добавляем путь до главного файла с разметкой
		$return['html']['_html']['link'] =  $result['basic']['link']['html'];
		// добавляем класс главного файла разметки
		$return['html']['_html']['class'] = self::$_instance->namespace . 'html';
		// Записываем дополнительные параметры страницы
		$return['html']['view']['param'] = $result['view']['config']['param'];
		/**
		 * Добавляем aside/nav/footer/header
		 */
		foreach (self::$settings['sub'] as $sub_name => $values) {
			$return['html']['sub'][$sub_name] = [
				'link' => $values['path']['root'] . 'Controller.php',
				'class' =>  $sub_name . '\Controller',
				'method' =>  'return',
				'method_name' => 'html',
				'data' => null,
			];
			if (isset($values['link']['css'])) {
				$return['html']['meta']['css'] += $values['link']['css'];
			}
			if (isset($values['link']['js'])) {
				$return['html']['meta']['css'] += $values['link']['js'];
			}
		}
		// Добавляем css главные
		if (isset($result['basic']['link']['css'])) {
			$return['html']['meta']['css'] += $result['basic']['link']['css'];
		}
		// Добавляем js главные
		if (isset($result['basic']['link']['js'])) {
			$return['html']['meta']['js'] += $result['basic']['link']['js'];
		}
		// Добавляем css вида
		if (isset($result['view']['link']['css'])) {
			$return['html']['meta']['css'] += $result['view']['link']['css'];
		}
		// Добавляем js вида
		if (isset($result['view']['link']['js'])) {
			$return['html']['meta']['js'] += $result['view']['link']['js'];
		}
		$return['require'] = $result__view['config']['require'];
		$return['routes'] = $result['basic']['routes'];
		return $return;
	}
	/**
	 * Формирование вида по маршруту
	 */
	private static function Router()
	{
		$url_array = self::$url_array;
		$return = ['error' => 'view not found'];
		$path_views = self::$_instance->data['path']['views'];
		$routes = self::$_instance->data['routes'];

		if (!isset($url_array[0])) {
			$url_array[0] = $routes['main']['alias'];
		}
		$check = false;
		foreach ($routes as $result) {
			if ($result['alias'] === $url_array[0]) {
				$check = true;
				$route = $result;
				$root = $path_views . $route['folder_name'];
				$link = $root . 'Controller.php';

				$include = \system\functions\sub::include($link);
				if (isset($include['error'])) {
					new \Ex($include['error'], 'page', 10);
				} else {
					$class = 'view\Controller';
					$method = 'return';
					$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
					if (isset($check_ClassAndMethod['error'])) {
						new \Ex($check_ClassAndMethod['error']);
					} else {
						$result = $class::$method(['root' => $root, 'return' => [
							'return_Data' => [
								'data' => ['link', 'path'],
								'config' => ['config'],
							],
						]]);
						if (isset($result['error'])) {
							new \Ex($result['error']);
						} else {
							$method = 'param';
							$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);

							if (!isset($check_ClassAndMethod['error'])) {
								$view_param =  $class::$method(['url_array' => $url_array]);
								if (isset($view_param['meta'])) {
									$result['config']['meta'] = $view_param['meta'];
								}
								if (isset($view_param['content'])) {
									$result['view']['content'] = $view_param['content'];
								} else {
									$result['view']['content'] = null;
								}
							}

							$return = $result;
						}
					}
				}
				break;
			}
		}
		if ($check !== false) {
			return $return;
		}
	}
	private static function add_sub()
	{
		$path_sub = self::$_instance->data['path']['sub'];
		$list_sub = \FoldersAndFiles::folder_ListFolders($path_sub);

		if (empty($list_sub)) {
			new \Ex(\ExDetailsText::empty('list_sub'));
		} else {
			foreach ($list_sub as $sub) {
				$root =  $path_sub . $sub . '/';
				$link = $root  . 'Controller.php';
				$include = \system\functions\sub::include($link);
				if (isset($include['error'])) {
					new \Ex($include['error']);
				} else {
					$class = $sub . '\\Controller';
					$method = 'return';
					$check_ClassAndMethod = \system\functions\sub::check_ClassAndMethod($class, $method);
					if (isset($check_ClassAndMethod['error'])) {
						new \Ex(\ExDetailsText::class_or_method($class, $method, 'base/add/' . $sub));
					} else {
						$result_sub = $class::$method(['root' => $root, 'return' => [
							'return_Data' => [
								'data' => ['link', 'path'],
								'config' => ['config'],
							]
						]]);

						if (isset($result['error'])) {
							new \Ex($result['error']);
						}
						if (isset($result_sub['error'])) {
							new \Ex($result_sub['error']);
						} else {
							self::$settings['sub'][$sub] = $result_sub;
						}
					}
				}
			}
		}
	}
}
