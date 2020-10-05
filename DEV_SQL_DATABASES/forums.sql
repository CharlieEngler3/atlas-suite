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
-- Database: `forums`
--

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
  `comments` text NOT NULL,
  `comment_users` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `image_links`, `user`, `comments`, `comment_users`) VALUES
(1, 'Example Post', 'Example body text for post.', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1', 'charlieengler3', 'This is a comment.⎖This is another comment.⎖Yet another comment.⎖', 'charlieengler3⎖charlieengler3⎖charlieengler3⎖'),
(8, 'Another Example Post', 'Body text', '', 'charlieengler3', 'This is a comment.⎖This is another comment.⎖Yet another comment.⎖', 'charlieengler3⎖charlieengler3⎖charlieengler3⎖'),
(9, 'Multiple Images', 'Body text', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1⎖https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FgD4uACwPChA%2Fmaxresdefault.jpg&f=1&nofb=1', 'charlieengler3', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
