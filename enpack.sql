-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 02:41 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enpack`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `cid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `level` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`cid`, `title`, `lang`, `level`, `duration`, `description`, `image`, `created_at`) VALUES
(1, 'english for kids', 'English', 'Beginner', 10, 'The English for Kids program at the American Academy for Training Courses (AATC)\r\n                consists of 6 courses. The American Academy (AATC) is one of the largest language\r\n                learning centers all over Egypt.\r\n\r\n                  â€œEnglish for Kidsâ€ courses are designed specifically for kids aged 6-12 years. It\r\n                  qualifies kids to master English and motivates them to practice English\r\n                  confidently. The courses are mainly based on fun learning approaches. It prepares\r\n                  kids to pass the tests of the Cambridge professional English test for kids, held\r\n                  at the British Council.\r\n               \r\n                  â€œEnglish for Kidsâ€ courses are the first step for kids towards attending\r\n                  prestigious universities in the future, such as the American University in Cairo\r\n                  and other major universities in Egypt and around the world.\r\n                \r\n                  â€œEnglish for Kidsâ€ courses are designed specifically for kids aged between 8 and\r\n                  13 years, with very effective interactive approaches based on fun activities\r\n                \r\n                  In â€œEnglish for Kidsâ€ courses, the kids enjoy many interesting English songs,\r\n                  stories, as well as studying phonetics in funny ways using interactive interesting\r\n                  methodologies.\r\n                \r\n                  To join the course, learners have to take a placement test. Upon completion of the\r\n                  course, the learner takes a final exam to measure his/her proficiency at the\r\n                  level. Upon passing that final exam, the learner can pass on to the next level and\r\n                  get a certificate showing the completed courses.', '6867c11c9ba73-english-for-kids.webp', 2147483647),
(3, 'General English Courses', 'English', 'Intermediate', 45, 'General English Courses (GEC): Overview\r\n            \r\n                The American Academy for Training Courses (AATC) American General English program is\r\n                made up of 16 levels. The American Academy is an ISO 9001 certified and authorized\r\n                language learning and training center. It works in partnership with the US-based\r\n                Atlanta Institute, and the American Academy is one of the largest language learning\r\n                centers all over Egypt.\r\n             \r\n                  The General English Courses include 16 levels. Each level lasts for 4 weeks, with\r\n                  two sessions per week.\r\n                \r\n                  The courses cover all English language skills, including listening, reading,\r\n                  writing and fluent conversations. Each course introduces learners, through\r\n                  extensive exercises, to a wide variety of vocabulary items and grammatical rules.\r\n               \r\n                  General English Courses is a program developed particularly for learners who like\r\n                  to master English and speak it fluently.\r\n                \r\n                  General English courses adopt interesting methodologies to meet learner needs.\r\n                \r\n                  The American Academy English learning courses are based on practical exercises and\r\n                  motivational English learning methodologies. The courses also feature a huge range\r\n                  of engaging exercises, audio-visual material and self-help activities to encourage\r\n                  learners to improve their English language skills.\r\n                \r\n                  To join the course, learners have to take a placement test. Upon completion of the\r\n                  course, the learner takes a final exam to measure his/her proficiency at the\r\n                  level. Upon passing that final exam, the learner can pass on to the next level and\r\n                  get a certificate showing the completed courses.', '6867ca01e73cd-general-english-course.webp', 1751632385),
(4, 'Business English Courses (BEC)', 'English', 'Advanced', 65, 'Business English Courses (BEC)\r\n\r\n                The American Academy for Training Courses (AATC) American Business English Program\r\n                is made up of 6 courses. The American Academy is an ISO 9001 certified and\r\n                authorized language learning and training center. It works in partnership with the\r\n                US-based Atlanta Institute, and the American Academy is one of the largest language\r\n                learning centers all over Egypt.\r\n          \r\n                  The American Academy provides Business English Courses (BEC) are designed\r\n                  specifically for professionals, managers, and businessmen to help them use English\r\n                  fluently in the workplace.\r\n                \r\n                  Course materials are closely related to professional management skills that\r\n                  stimulate to learners the professional environment at the workplace, help them\r\n                  develop their English reading, conversation, writing and listening skills.\r\n                  Learners work on case studies and topics about the business environment to learn\r\n                  how English is used in real situation.\r\n                \r\n                  To join the course, learners have to take a placement test. Upon completion of the\r\n                  course, the learner takes a final exam to measure his/her proficiency at the\r\n                  level. Upon passing that final exam, the learner can pass on to the next level and\r\n                  get a certificate showing the completed courses.', '6867ca7ac2b97-Business-English.webp', 1751632506);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `tel`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '', '$2y$10$9Fq5JxMaoQfrb8yMbVRheeTpa34DmZOG5SH.XDQcZaHgvf0xz7Mpe', 1, 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
