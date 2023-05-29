-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2023 at 11:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forums`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `replying_to` int(11) NOT NULL,
  `username` text NOT NULL,
  `replies` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post`, `post_id`, `comment`, `replying_to`, `username`, `replies`) VALUES
(1, 'Example Post', 1, 'This is a comment', 0, 'charlieengler3', 1),
(2, 'Example Post', 1, 'This is a reply to the comment', 1, 'charlieengler3', 0),
(3, 'Another Example Post', 8, 'This one has a comment, too.', 0, 'charlieengler3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `image_links` text NOT NULL,
  `user` text NOT NULL,
  `visibility` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `image_links`, `user`, `visibility`) VALUES
(1, 'Example Post', 'Example body text for post.\r\n\r\n(With an edit)', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1', 'charlieengler3', 'public'),
(8, 'Another Example Post', 'Body text', '', 'charlieengler3', 'public'),
(9, 'Multiple Images', 'Body text', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1', 'charlieengler3', 'public');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
