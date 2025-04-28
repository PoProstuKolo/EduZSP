-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 01, 2024 at 08:28 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduzsp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `administrators`
--

CREATE TABLE `administrators` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`admin_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `question_id`, `answer_text`, `is_correct`) VALUES
(33, 81, 'Habla', 0),
(34, 81, 'Abla', 0),
(35, 81, 'Abla Habla', 0),
(36, 81, 'Habla Abla', 1),
(37, 82, '1', 0),
(38, 82, '2', 1),
(39, 82, '3', 0),
(40, 82, '4', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `bans`
--

INSERT INTO `bans` (`id`, `user_id`) VALUES
(7, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `test_id`, `question_text`) VALUES
(69, 18, 'Kiedy podpisano Deklarację Niepodległości?'),
(70, 18, 'Kto był pierwszym prezydentem Stanów Zjednoczonych?'),
(71, 18, 'W którym roku zakończyła się II wojna światowa?'),
(72, 18, 'Jaka jest stolica Francji?'),
(73, 19, 'Jaki jest symbol chemiczny dla wody?'),
(74, 19, 'Jaka jest największa planeta w naszym układzie słonecznym?'),
(75, 19, 'Jaki jest proces, dzięki któremu rośliny wytwarzają swoje pożywienie?'),
(76, 19, 'Kto sformułował teorię względności?'),
(77, 20, 'Kto napisał \"Zabić drozda\"?'),
(78, 20, 'Jaka jest sceneria książki \"Duma i uprzedzenie\"?'),
(79, 20, 'Jakie jest imię głównego bohatera w \"Wielkim Gatsbym\"?'),
(80, 20, 'Kto napisał \"1984\"?'),
(81, 21, 'Habla abla?'),
(82, 21, 'asd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `student_answers`
--

CREATE TABLE `student_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`id`, `user_id`, `question_id`, `answer`) VALUES
(1, 1, 81, '36'),
(2, 1, 82, '37'),
(9, 1, 81, '34'),
(10, 1, 82, '37'),
(11, 1, 81, '34'),
(12, 1, 82, '37'),
(13, 1, 81, '34'),
(14, 1, 82, '37'),
(15, 1, 81, '34'),
(16, 1, 82, '37'),
(17, 1, 81, '34'),
(18, 1, 82, '37'),
(19, 1, 81, '34'),
(20, 1, 82, '37'),
(21, 1, 81, '34'),
(22, 1, 82, '37'),
(23, 1, 81, '34'),
(24, 1, 82, '37'),
(25, 1, 81, '34'),
(26, 1, 82, '37'),
(27, 1, 81, '34'),
(28, 1, 82, '37'),
(29, 16, 81, '35'),
(30, 16, 82, '38'),
(31, 16, 81, '36'),
(32, 16, 82, '40');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(13, 15);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Czas trwania testu podany w minutach',
  `number_of_questions` int(11) DEFAULT NULL,
  `category` text NOT NULL,
  `test_code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `teacher_id`, `test_name`, `duration`, `number_of_questions`, `category`, `test_code`) VALUES
(18, 2, 'Historia', 45, 4, '', 'UIOPAS'),
(19, 3, 'Nauki przyrodnicze', 40, 4, '', 'DFGHJK'),
(20, 4, 'Literatura', 35, 4, '', 'LZXCVB'),
(21, 1, 'test', 20, 2, 'test', 'Cx9jZO');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `surename` varchar(45) NOT NULL,
  `mobile_number` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `surename`, `mobile_number`, `email`, `password`, `active`) VALUES
(1, 'Admin', 'Admin', 123456679, 'admin@admin.pl', 'admin', 1),
(2, 'Nauczyciel', 'Nauczyciel', 123456789, 'nauczyciel@nauczyciel.pl', 'nauczyciel', 1),
(3, 'Uczeń', 'Uczeń', 123456789, 'uczen@uczen.pl', 'uczen', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indeksy dla tabeli `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indeksy dla tabeli `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indeksy dla tabeli `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `administrators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`);

--
-- Constraints for table `bans`
--
ALTER TABLE `bans`
  ADD CONSTRAINT `bans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`),
  ADD CONSTRAINT `test_id` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`);

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `student_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
