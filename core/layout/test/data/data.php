<?php

namespace layout;

class data
{
	private const name = 'layout'; // Имя файла стилей и скриптов
	/**************************************************************************/
	/* Список папок */
	/**************************************************************************/
	private const folders = [
		'layout' => 'layout/',
		'sub' => 'sub/',
		'html' => 'html/',
		'apps' => 'apps/',
		'data' => 'data/',
		'system' => 'system/',
		'views' => 'views/',
		'res' => 'res/', // Папка с js, css, img
		'img' => 'img/',
		'logo' => 'logo/',
		'bg' => 'bg/',
		'style' => 'style/',
		'css' => 'css/', // Папка с css
		'css_min' => 'css_min/', // Папка с css_min
		'scss' => 'scss/', // Папка с scss
		'js' => 'js/', // Папка с js
		'db' => 'db/',
	];
	/**************************************************************************/
	/* Списки файлов */
	/**************************************************************************/
	private const files = 	[
		'html' => '_html.php',
		'auth' => 'auth.php',
		'css' =>  self::name . '.css', // Имя файла cms стилей
		'css_min' =>  self::name . '.min.css', // Имя файла cms стилей
		'css_m' => 'm_' . self::name . '.css', // Имя файла cms стилей
		'css_min_m' => 'm_' . self::name . '.min.css', // Имя файла cms стилей
		'js' => self::name . '.js',
		'db_connect' => 'connect.php',
		'db_read' => 'read.php'
	];

	/**************************************************************************/
	/* Пути к папкам */
	/**************************************************************************/
	private  $path = [
		'views' => self::folders['views'],
		'apps' =>  self::folders['apps'],
		'data' =>  self::folders['data'],
		'res' =>  self::folders['res'],
		'sub' =>  self::folders['sub'],
		'db' => self::folders['db'],
		'img' => self::folders['res'] . self::folders['img'],
	];

	/**************************************************************************/
	/* Ссылки для подключения файлов */
	/**************************************************************************/
	private	$link = [
		'html' => self::files['html'],
		'auth' =>  self::folders['data'] .  self::files['auth'],
		'css' => [
			self::name  => [
				'css' =>   self::folders['res'] . self::folders['style'] . self::folders['css'] . self::files['css'],  // Файл с css
				'css_min' =>   self::folders['res'] . self::folders['style'] . self::folders['css_min'] . self::files['css_min'],  // Файл с min.css
				'css_m' =>  self::folders['res'] . self::folders['style'] . self::folders['css'] . self::files['css_m'],  // Файл с css mobile
				'css_min_m' =>  self::folders['res'] . self::folders['style'] . self::folders['css_min'] . self::files['css_min_m'],  // Файл с min.css mobile
			]
		],

		'js' => [
			self::name  => [
				self::name => self::folders['res'] . self::folders['js'] . self::files['js'],
			]
		],

		'db' => [
			'connect' =>  self::folders['db'] .  self::files['db_connect'],
			'read' =>  self::folders['db'] .  self::files['db_read'],
		]
	];
	use \traits\BaseMethods;
}
