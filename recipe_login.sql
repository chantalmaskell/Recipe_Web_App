-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2023 at 09:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `recipe_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Prep_time` varchar(255) NOT NULL,
  `Cook_time` varchar(255) NOT NULL,
  `Rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `Name`, `Description`, `Prep_time`, `Cook_time`, `Rating`) VALUES
(1, 'Spaghetti Bolognese', 'It consists of spaghetti served with a sauce made from tomatoes, minced beef, garlic, wine and herbs', '30 minutes', '1 to 2 hours', 5);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_categories`
--

CREATE TABLE `recipe_categories` (
  `recipe_id` int(11) NOT NULL,
  `Category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_categories`
--

INSERT INTO `recipe_categories` (`recipe_id`, `Category`) VALUES
(1, 'Main'),
(1, 'Meat'),
(1, 'Pasta');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `recipe_id` int(11) NOT NULL,
  `Ingredient` varchar(255) NOT NULL,
  `Quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`recipe_id`, `Ingredient`, `Quantity`) VALUES
(1, 'Olive oil', '2 tbsp'),
(1, 'Chopped smoked streaky bacon', '6 rashers'),
(1, 'Chopped onions', '2 large'),
(1, 'Garlic cloves', '3'),
(1, 'Minced beaf', '1kg'),
(1, 'Red wine', '2 large glasses'),
(1, 'Chopped tomatoes', '2x400g cans'),
(1, 'Antipasti marinated mushrooms', '1x290g jar'),
(1, 'Bay leaves', '2 fresh or dried'),
(1, 'Oregano', '1 tsp dried'),
(1, 'Thyme', '1 tsp dried'),
(1, 'Balsamic vinegar', 'Drizzle'),
(1, 'Sun-dried tomato halves in oil', '12-14'),
(1, 'Salt and pepper', 'Pinch'),
(1, 'Fresh basil leaves', 'Handful'),
(1, 'Dried spaghetti', '800g-1kg'),
(1, 'Freshly grated parmesan', 'Handful');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_steps`
--

CREATE TABLE `recipe_steps` (
  `recipe_id` int(11) NOT NULL,
  `Step_number` int(11) NOT NULL,
  `Description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_steps`
--

INSERT INTO `recipe_steps` (`recipe_id`, `Step_number`, `Description`) VALUES
(1, 1, 'Heat the oil in a large, heavy-based saucepan and fry the bacon until golden over a medium heat. Add the onions and garlic, frying until softened. Increase the heat and add the minced beef. Fry it until it has browned, breaking down any chunks of meat with a wooden spoon. Pour in the wine and boil until it has reduced in volume by about a third. Reduce the temperature and stir in the tomatoes, drained mushrooms, bay leaves, oregano, thyme and balsamic vinegar.'),
(1, 2, 'Either blitz the sun-dried tomatoes in a small blender with a little of the oil to loosen, or just finely chop before adding to the pan. Season well with salt and pepper. Cover with a lid and simmer the Bolognese sauce over a gentle heat for 1-1½ hours until it\'s rich and thickened, stirring occasionally. At the end of the cooking time, stir in the basil and add any extra seasoning if necessary.'),
(1, 3, 'Remove from the heat to \'settle\' while you cook the spaghetti in plenty of boiling salted water (for the time stated on the packet). Drain and divide between warmed plates. Scatter a little parmesan over the spaghetti before adding a good ladleful of the Bolognese sauce, finishing with a scattering of more cheese and a twist of black pepper.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `hash_password`) VALUES
(1, 'rob', 'rc@outlook.com', '$2y$10$KBOMT1FjnRm9AXsAXX3BvOJNhOY3nwECLoXSXRaZFfez7kRcxqVP2'),
(17, 'rob', 'r@outlook.com', '$2y$10$kkK0qA/AgV06Ok6vL8EXiOTUEEQnnSMcl6xROPKsYC16ZK5C.Dig6'),
(20, 'rob', 'arc@outlook.com', '$2y$10$miw1Wa0RTBWVzT.4r83tbueBDHdQ.gt62rxMcH1Y3G1BUBxHcync.'),
(21, 'rob', 'eb@outlook.com', '$2y$10$SxDyKxYjk3xLsR.1zRRWdOSlrr3RKBjVKce6H3Tkvs2qEJvr24y/O'),
(22, 'rob', 'robc@outlook.com', '$2y$10$egGoEFIgtEQ0GFtrmZFpNe0ZheMSziPVb72jjuQNkKNdUNYdEg8F2'),
(23, 'a', 'a@a.com', '$2y$10$ie8d/mrSWuqoENZbBCuYFeaDCHec5dyBt0XoS3C3tD9lll2Ss27Yi'),
(24, 'b', 'b@outlook.com', '$2y$10$skvG7KhM9xNk9P06YcEHVOP6F1ijo4fQxoGRsCNgC2FdJ/G4dvZwa'),
(26, 'r', 'a@outlook.com', '$2y$10$yZD1XmyaNzIvWKw0QaM10uB.XqpeL1ZBXx6fR.ms3s79CEhDBxJAC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`recipe_id`),
  ADD UNIQUE KEY `recipe_id` (`recipe_id`,`user`),
  ADD UNIQUE KEY `recipe_id_2` (`recipe_id`,`user`),
  ADD KEY `user_id` (`user`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD UNIQUE KEY `Category` (`Category`),
  ADD KEY `id` (`recipe_id`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD KEY `recipe` (`recipe_id`);

--
-- Indexes for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD CONSTRAINT `id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  ADD CONSTRAINT `recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
