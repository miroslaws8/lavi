-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 06 2020 г., 14:40
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dev_tasks`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `author` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `text` text NOT NULL,
  `status` enum('new','pending','done') NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` datetime DEFAULT NULL,
  `edited` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `author`, `email`, `text`, `status`, `cdate`, `mdate`, `edited`) VALUES
(1, 'Miroslaws', 'test@test.com', 'text', 'new', '2020-04-04 18:34:08', '0000-00-00 00:00:00', 0),
(2, 'gaag', 'test@test.com', 'text', 'new', '2020-04-04 19:44:45', '0000-00-00 00:00:00', 0),
(3, 'Miro', 'test@test.com', 'Для Вашего удобства предоставляю протокол тестирования, по которому проверяется тестовое задание.\r\n1) Перейти на стартовую страницу приложения. Должен отобразиться список задач. В списке присутствуют поля: имя пользователя, email, текст задачи, статус. Не должно быть опечаток. Зазоры должны быть ровные. Ничего не ползет. Должна быть возможность создания новой задачи. Должна быть кнопка для авторизации.\r\n2) Не заполнять поля для новой задачи. Сохранить задачу. Должны вывестись ошибки валидации. Ввести в поле email “test”. Должна вывестись ошибка, что email не валиден. ', 'new', '2020-04-04 19:52:02', '0000-00-00 00:00:00', 0),
(4, 'gaag', 'test@test.com', 'gavv', 'new', '2020-04-04 19:53:48', '0000-00-00 00:00:00', 0),
(5, 'gaga', 'test@test.com', 'gaagag', 'new', '2020-04-04 19:54:40', '0000-00-00 00:00:00', 0),
(6, 'Miroslaws', 'test@test.com', 'Сделайте вход для администратора (логин &quot;admin&quot;, пароль &quot;123&quot;). Администратор имеет возможность редактировать текст задачи и поставить галочку о выполнении. Выполненные задачи в общем списке выводятся с соответствующей отметкой. \r\n', 'new', '2020-04-04 21:32:46', '0000-00-00 00:00:00', 0),
(7, 'Miroslaws', 'test@test.com', 'Стартовая страница - список задач с возможностью сортировки по имени пользователя, email и статусу. Вывод задач нужно сделать страницами по 3 штуки (с пагинацией). Видеть список задач и создавать новые может любой посетитель без авторизации.', 'new', '2020-04-04 21:33:08', '0000-00-00 00:00:00', 0),
(8, 'test', 'test@test.com', 'test job', 'new', '2020-04-06 11:23:03', '0000-00-00 00:00:00', 0),
(9, 'test2', 'test@test.com', '&lt;script&gt;alert(‘test’);&lt;/script&gt;vvvv', 'done', '2020-04-06 11:23:12', '2020-04-06 13:50:29', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_type` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `id_type`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_types`
--

CREATE TABLE `users_types` (
  `id` int(11) NOT NULL,
  `ident` varchar(32) NOT NULL,
  `caption` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_types`
--

INSERT INTO `users_types` (`id`, `ident`, `caption`) VALUES
(1, 'admin', 'Admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
