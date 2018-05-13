-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2018 at 04:00 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.2.2-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vkvxweok_mbd_05111640000033`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_rating` (`p_type_rating_id` INTEGER, `p_level_id` INTEGER, `p_type_id` INTEGER, `p_user_id` INTEGER, `p_rating` INTEGER)  BEGIN
	set @id = (select max(`rating_id`) from `rating` group by rating_id) +1;
	insert into rating values(@id, p_type_rating_id, p_level_id, p_type_id, p_user_id, p_rating);
	select 1, 'Berhasil!';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_change_password` (`p_username` VARCHAR(100), `p_old_pass` VARCHAR(25), `p_new_pass` VARCHAR(25))  BEGIN
	if exists (select 1 from `user` where `username` = p_username and `password` = md5(p_old_pass)) then
		if md5(p_new_pass) = (select `password` from `user` where username = p_username) then
			select 0, 'Password didnt change!';
		else
			update `user` set `password` = md5(p_new_pass) where username = p_username;
			select 1, 'Password has been changed successfully!';
		end if;
	else
		select 0, 'Your old password was entered incorrectly';
	end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_create_room` (IN `p_level` INT, IN `p_name` VARCHAR(100), IN `p_password` VARCHAR(100))  NO SQL
BEGIN
	SET @id = (SELECT MAX(room_id)+1 FROM room_detail GROUP BY room_id ORDER BY room_id DESC LIMIT 1);
    INSERT INTO room VALUES (@id,p_level,p_name,MD5(p_password),1);
    SELECT 1,"BERHASIL";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_daftar` (IN `p_username` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(25))  BEGIN
	if not exists (select 1 from `user` where email = p_email and username = p_username) then
		set @id = (select max(`user_id`)+1 from `user` group by user_id);
		insert into `user` values (@id, 0,p_username, p_email, md5(p_password), 0, 0);
		select 1, 'Pendaftaran Sukses!';
	else
		select 0, 'Pendaftaran Gagal, Email atau Username sudah dipakai!';
	end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_into_room` (IN `p_room_id` INT, IN `p_user_id` INT)  BEGIN
	if not exists(select 1 from room where room_id = p_room_id and user_id = p_user_id) then
		insert into room values(p_room_id, p_user_id, null, null,0);
		select 1, 'Berhasil!';
	else
		select 0, 'Gagal!';
	end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `p_email` VARCHAR(100), IN `p_password` CHAR(32))  BEGIN
	IF EXISTs (select 1 from `user` where email = p_email and `password` = md5(p_password)) then
		select 1, 'Login Sukses!',p_email;
	else
		select 0, 'Email atau Password salah!','@';
	end if;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_get_max_level` () RETURNS INT(11) NO SQL
BEGIN
	RETURN (SELECT MAX(`level_id`) FROM `level` GROUP BY level_id order by level_id DESC limit 1 );

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fn_is_joined_room` (`p_room_id` INT, `p_user_id` INT) RETURNS INT(11) READS SQL DATA
BEGIN
	IF EXISTS (SELECT 1 FROM room WHERE room_id = p_room_id AND user_id = p_user_id) THEN
    	RETURN 1;
    ELSE
    	RETURN 0;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `highscore`
--

CREATE TABLE `highscore` (
  `highscore_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `grid` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `grid`) VALUES
(0, '0'),
(1, '1'),
(2, '0'),
(3, '0');

-- --------------------------------------------------------

--
-- Table structure for table `level_detail`
--

CREATE TABLE `level_detail` (
  `level_level` int(11) NOT NULL,
  `max_exp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_detail`
--

INSERT INTO `level_detail` (`level_level`, `max_exp`) VALUES
(0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `level_rule_desc`
--

CREATE TABLE `level_rule_desc` (
  `level_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `type_rating_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `user_id`, `start_time`, `end_time`, `score`) VALUES
(0, 1, '2018-05-13 08:20:14', '2018-05-13 08:20:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_detail`
--

CREATE TABLE `room_detail` (
  `room_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `avaiable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_detail`
--

INSERT INTO `room_detail` (`room_id`, `level_id`, `name`, `password`, `avaiable`) VALUES
(0, 0, '0', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rule`
--

CREATE TABLE `rule` (
  `rule_id` int(11) NOT NULL,
  `rule_title` varchar(50) DEFAULT NULL,
  `rule_desc` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(11) NOT NULL,
  `type_title` varchar(50) DEFAULT NULL,
  `type_description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `type_rating`
--

CREATE TABLE `type_rating` (
  `type_rating_id` int(11) NOT NULL,
  `type_rating_title` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `level_level` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `user_level` int(11) DEFAULT NULL,
  `exp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `level_level`, `username`, `email`, `password`, `user_level`, `exp`) VALUES
(0, 0, '0', '0', '0', 0, 0),
(1, 0, 'asd', 'asd@asd.com', '7815696ecbf1c96e6894b779456d330e', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `highscore`
--
ALTER TABLE `highscore`
  ADD PRIMARY KEY (`highscore_id`),
  ADD KEY `FK_highscore_type` (`type_id`),
  ADD KEY `FK_level_highscore` (`level_id`),
  ADD KEY `FK_user_highscore` (`user_id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `level_detail`
--
ALTER TABLE `level_detail`
  ADD PRIMARY KEY (`level_level`);

--
-- Indexes for table `level_rule_desc`
--
ALTER TABLE `level_rule_desc`
  ADD PRIMARY KEY (`level_id`,`rule_id`),
  ADD KEY `FK_level_rule_desc2` (`rule_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `FK_rating_level` (`level_id`),
  ADD KEY `FK_rating_type` (`type_id`),
  ADD KEY `FK_type_rating_detail` (`type_rating_id`),
  ADD KEY `FK_user_rating` (`user_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`,`user_id`),
  ADD KEY `FK_room_user` (`user_id`);

--
-- Indexes for table `room_detail`
--
ALTER TABLE `room_detail`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`rule_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `type_rating`
--
ALTER TABLE `type_rating`
  ADD PRIMARY KEY (`type_rating_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_lvl` (`level_level`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `highscore`
--
ALTER TABLE `highscore`
  ADD CONSTRAINT `FK_highscore_type` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`),
  ADD CONSTRAINT `FK_level_highscore` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`),
  ADD CONSTRAINT `FK_user_highscore` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `level_rule_desc`
--
ALTER TABLE `level_rule_desc`
  ADD CONSTRAINT `FK_level_rule_desc` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`),
  ADD CONSTRAINT `FK_level_rule_desc2` FOREIGN KEY (`rule_id`) REFERENCES `rule` (`rule_id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_rating_level` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`),
  ADD CONSTRAINT `FK_rating_type` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`),
  ADD CONSTRAINT `FK_type_rating_detail` FOREIGN KEY (`type_rating_id`) REFERENCES `type_rating` (`type_rating_id`),
  ADD CONSTRAINT `FK_user_rating` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `FK_room_detail` FOREIGN KEY (`room_id`) REFERENCES `room_detail` (`room_id`),
  ADD CONSTRAINT `FK_room_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `room_detail`
--
ALTER TABLE `room_detail`
  ADD CONSTRAINT `FK_room_detail_level` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_lvl` FOREIGN KEY (`level_level`) REFERENCES `level_detail` (`level_level`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
