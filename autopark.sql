-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 02 2023 г., 00:52
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `autopark`
--

-- --------------------------------------------------------

--
-- Структура таблицы `autoparks`
--

CREATE TABLE `autoparks` (
  `id` int NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `schedule` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `autoparks`
--

INSERT INTO `autoparks` (`id`, `title`, `address`, `schedule`) VALUES
(1, 'Гороховый', 'улица Горохова, дом 7', 'ежедневно 7:00-21:00 вс - выходной'),
(2, 'Тутуева2', 'ул. Тутуева, д. 128', ''),
(3, 'Углова', 'Улица Углова дом 8', 'круглосуточно'),
(5, 'Ульяновский', 'улица Ульяновская, 128', ''),
(12, 'Нутина', 'улица Нутина, 28 к2', '');

-- --------------------------------------------------------

--
-- Структура таблицы `autopark_cars`
--

CREATE TABLE `autopark_cars` (
  `id` int NOT NULL,
  `autopark_id` int NOT NULL,
  `car_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `autopark_cars`
--

INSERT INTO `autopark_cars` (`id`, `autopark_id`, `car_id`) VALUES
(1, 1, 1),
(5, 1, 4),
(10, 1, 11),
(2, 2, 1),
(3, 2, 4),
(11, 3, 12),
(13, 5, 1),
(16, 12, 1),
(15, 12, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `number` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `driver_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `number`, `user_id`, `driver_name`) VALUES
(1, 'х423рв', 3, 'RyanGosling'),
(4, 'а357кн', 3, 'RyanGosling'),
(5, 'asdasdf', 3, 'RyanGosling'),
(6, 'asdasdf', 3, 'RyanGosling'),
(11, 'ff3324', NULL, 'Ilya'),
(12, 'п493дс', NULL, 'Илья'),
(13, 'а986', NULL, 'Лилус'),
(15, 'и680гр', 6, 'Боб');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`) VALUES
(2, 'aboba', 'admin@admin.ru', '4297f44b13955235245b2497399d7a93', 2),
(3, 'RyanGosling', 'ryan@gosling.ru', 'f5bb0c8de146c67b44babbf4e6584cc0', 1),
(6, 'Боб', 'bob@bob.ru', '4297f44b13955235245b2497399d7a93', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`id`, `title`) VALUES
(1, 'Водитель'),
(2, 'Менеджер');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `autoparks`
--
ALTER TABLE `autoparks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `autopark_cars`
--
ALTER TABLE `autopark_cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autopark_id` (`autopark_id`,`car_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Индексы таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `autoparks`
--
ALTER TABLE `autoparks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `autopark_cars`
--
ALTER TABLE `autopark_cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `autopark_cars`
--
ALTER TABLE `autopark_cars`
  ADD CONSTRAINT `autopark_cars_ibfk_1` FOREIGN KEY (`autopark_id`) REFERENCES `autoparks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `autopark_cars_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
