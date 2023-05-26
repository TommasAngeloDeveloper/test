-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2023 г., 04:37
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `position` int(11) DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `articul` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `price_old` decimal(10,2) NOT NULL,
  `notice` text,
  `content` text,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `position`, `url`, `name`, `articul`, `price`, `currency_id`, `price_old`, `notice`, `content`, `visible`) VALUES
(1, 0, 'KAMA__132155', 'KAMA', '132155', '20500.00', 1, '23500.00', 'Затеки', 'Содержание', 1),
(3, 0, 'KAMA__133478', 'KAMA', '133478', '29000.00', 1, '0.00', 'заметки', 'Содержание', 1),
(4, 0, 'NOKIAN_TYRES__964210', 'NOKIAN TYRES', '964210', '7000.00', NULL, '7000.00', 'заметки', 'Шина летняя легковая 195/65R15 91H', 1),
(5, 0, 'Cordiant__1305233460 ', 'Cordiant', '1305233460 ', '4400.00', NULL, '4400.00', 'заметки', 'Шина летняя легковая 185/65R15 88H', 1),
(6, 0, 'GENERAL_MOTORS__93165557', 'GENERAL MOTORS', '93165557', '3700.00', NULL, '3700.00', 'заметки', 'Масло моторное Dexos 2 5W-30 синтетическое 5 л', 1),
(7, 0, 'Hyundai-KIA__0310000110', 'Hyundai-KIA', '0310000110', '1050.00', NULL, '1000.00', 'заметки', 'Жидкость гидроусилителя New PSF -3 желтый 1 л', 1),
(8, 0, 'uny__1020', 'uny', '1020', '1500.00', NULL, '1500.00', 'заметки', 'универсальное масло', 1),
(9, 0, 'Filtron__OP5201', 'Filtron', 'OP5201', '390.00', NULL, '390.00', 'заметки', 'Фильтр масляный ВАЗ 2108-09 FILTRON OP520/1', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_assignment`
--

CREATE TABLE `product_assignment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_assignment`
--

INSERT INTO `product_assignment` (`id`, `product_id`, `section_id`, `type_id`, `visible`) VALUES
(10, 1, 1, 1, 1),
(11, 3, 1, 1, 1),
(12, 4, 1, 1, 1),
(13, 5, 1, 1, 1),
(14, 6, 2, 3, 1),
(15, 7, 2, 4, 1),
(16, 8, 2, 3, 1),
(17, 8, 2, 4, 1),
(18, 9, 3, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_param_name`
--

CREATE TABLE `product_param_name` (
  `id` int(10) UNSIGNED NOT NULL,
  `position` int(11) DEFAULT '0',
  `visible` tinyint(1) NOT NULL,
  `name` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `product_param_variant`
--

CREATE TABLE `product_param_variant` (
  `id` int(10) UNSIGNED NOT NULL,
  `param_id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `position` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `product_section`
--

CREATE TABLE `product_section` (
  `id` int(10) UNSIGNED NOT NULL,
  `position` int(11) DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `notice` text,
  `visible` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_section`
--

INSERT INTO `product_section` (`id`, `position`, `url`, `name`, `notice`, `visible`) VALUES
(1, 0, 'shini_i_diski', 'Шины и диски', 'Шины и диски', 0),
(2, 0, 'oil', 'Масла и жидкости', 'Масла и жидкости', 0),
(3, 0, 'filters', 'Фильтра', 'заметки', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `product_type`
--

CREATE TABLE `product_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `position` int(11) DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `notice` text,
  `visible` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_type`
--

INSERT INTO `product_type` (`id`, `position`, `url`, `name`, `notice`, `visible`) VALUES
(1, 0, 'tires', 'шины', 'шины', 0),
(2, 0, 'wheels', 'диски', 'тормозные жидкости', 4),
(3, 0, 'engine_oil', 'Масло моторное', 'заметки', 0),
(4, 0, 'transmission_oil', 'Масло трансмиссионное', 'заметки', 0),
(5, 0, 'oil_filter', 'фильтр масляный', 'заметки', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `currency_id` (`currency_id`);

--
-- Индексы таблицы `product_assignment`
--
ALTER TABLE `product_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `visible` (`visible`);

--
-- Индексы таблицы `product_param_name`
--
ALTER TABLE `product_param_name`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_param_variant`
--
ALTER TABLE `product_param_variant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`param_id`,`name`(64)),
  ADD KEY `param_id` (`param_id`);

--
-- Индексы таблицы `product_section`
--
ALTER TABLE `product_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url` (`url`);

--
-- Индексы таблицы `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url` (`url`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `product_assignment`
--
ALTER TABLE `product_assignment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `product_param_name`
--
ALTER TABLE `product_param_name`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product_param_variant`
--
ALTER TABLE `product_param_variant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product_section`
--
ALTER TABLE `product_section`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
