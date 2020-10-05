-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2020 at 02:22 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `notes` text NOT NULL,
  `user` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `notes`, `user`) VALUES
(14, 'English HW', '<br/><input type=checkbox name=check onclick=SubmitForm(this); checked>Complete conspiracy paragraphs 10/1 <br/><input type=checkbox name=check onclick=SubmitForm(this);>Conspiracy essay 10/4', 'charlieengler3'),
(15, 'Gov HW', '<br/><input type=checkbox name=check onclick=SubmitForm(this); checked>Federalism FRQ - Review definitions and foundational documents 10/1<br/><input type=checkbox name=check onclick=SubmitForm(this); checked>Current event presentation 10/2<br/><input type=checkbox name=check onclick=SubmitForm(this);>MC test on Chapters 2 and 3 10/5<br/><input type=checkbox name=check onclick=SubmitForm(this);>Rewrite Constitution FRQ 10/5<br/><input type=checkbox name=check onclick=SubmitForm(this);>Chapter 6 notes 10/6<br/><input type=checkbox name=check onclick=SubmitForm(this);>Annotated bibliography 10/13<br/><input type=checkbox name=check onclick=SubmitForm(this);>Final paper 10/20', 'charlieengler3'),
(16, 'Chem HW', '<br/><input type=checkbox name=check onclick=SubmitForm(this);>Assignment 7 10/7. <br/><input type=checkbox name=check onclick=SubmitForm(this);>Lab 10/5', 'charlieengler3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
