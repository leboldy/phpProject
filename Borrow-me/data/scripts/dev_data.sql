-- Initial Structure

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `roles`
-- --------------------------------------------------------
CREATE TABLE `roles` (
  `rol_id` int(11) NOT NULL,
  `rol_description` varchar(30) NOT NULL,
  `rol_type` char(1) NOT NULL COMMENT 'A= Admin | I= Investor | V= Vendor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_description`, `rol_type`) VALUES
(1, 'Administrador', 'A'),
(2, 'Investidor', 'I'),
(3, 'Vendedor', 'V');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `use_id` int(11) NOT NULL,
  `use_full_name` varchar(50) NOT NULL,
  `use_username` varchar(20) NOT NULL,
  `use_password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`use_id`, `use_full_name`, `use_username`, `use_password`) VALUES
(1, 'Jose Henrique Bodo', 'bodo', '123'),
(2, 'Rodrigo Bortoli', 'marelo', '123'),
(3, 'Leandro', 'boldy', '123'),
(4, 'Rodrigo justo', 'gordinho', '123');

-- --------------------------------------------------------
-- Table structure for table `user_roles`
-- --------------------------------------------------------

CREATE TABLE `user_roles` (
  `use_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`use_id`, `rol_id`) VALUES
(1, 1),
(3, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(4, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`),
  ADD UNIQUE KEY `rol_type` (`rol_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`use_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`use_id`,`rol_id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `use_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`use_id`) REFERENCES `users` (`use_id`),
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`);
COMMIT;

-- --------------------------------------------------------

INSERT INTO `roles` (`rol_id`, `rol_description`, `rol_type`) VALUES
(4, 'Cliente', 'C');

-- --------------------------------------------------------

CREATE TABLE `person` (
  `per_id` int(11) NOT NULL,
  `per_full_name` varchar(200) NOT NULL,
  `per_nickname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`per_id`, `per_full_name`, `per_nickname`) VALUES
(1, 'José Henrique Bodo', 'bodo'),
(2, 'Leandro Bodo', 'body'),
(3, 'Rodrigo Bortoli', 'marelo'),
(4, 'Rodrigo Justo', 'gordinho'),
(5, 'Leticia Bodo', 'lezinha');

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`per_id`);

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
-- --------------------------------------------------------

--
-- REMOVING FIELD FROM USERS

ALTER TABLE `users` DROP `use_full_name`;
-- --------------------------------------------------------

