-- This SQL is to insert all structure related to agent
-- Following table structure will be created
--      1. company
--      2. agent
--      3. features 
--      4. packages 
--      5. packages_features 
--      6. user_packages 
--      7. agent_packages
--      8. properties_attempts


-- --------------------------------------------------------
--
-- Table structure for table `company`
--
CREATE TABLE IF NOT EXISTS `company` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `registration_no` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `agent`
--
CREATE TABLE IF NOT EXISTS `agent` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `gender` enum('MALE', 'FEMALE') COLLATE utf8_bin NOT NULL,
  `birthday` datetime DEFAULT NULL,
  `mailing` varchar(100) COLLATE utf8_bin NOT NULL,
  `citizenship` varchar(100) COLLATE utf8_bin NOT NULL,
  `broker_num` varchar(100) COLLATE utf8_bin NOT NULL,
  `contact_num` int COLLATE utf8_bin NOT NULL,
  `location_id` int COLLATE utf8_bin NOT NULL,
  `user_id` int COLLATE utf8_bin NOT NULL,
  `company_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`location_id`) REFERENCES location(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`company_id`) REFERENCES company(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `features`
--
CREATE TABLE IF NOT EXISTS `features` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `type`  varchar(50) COLLATE utf8_bin NOT NULL,
  `price` decimal(10,2) COLLATE utf8_bin NOT NULL,
  `features_count` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `packages`
--
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `code`  varchar(50) COLLATE utf8_bin NOT NULL,
  `promotion`  varchar(300) COLLATE utf8_bin NOT NULL,
  `active` boolean COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `packages_features`
--
CREATE TABLE IF NOT EXISTS `packages_features` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `package_id` int COLLATE utf8_bin NOT NULL,
  `feature_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES packages(`id`),
  FOREIGN KEY (`feature_id`) REFERENCES features(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `user_packages`
--
CREATE TABLE IF NOT EXISTS `user_packages` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `package_id` int COLLATE utf8_bin NOT NULL,
  `user_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES packages(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `agent_packages`
--
CREATE TABLE IF NOT EXISTS `agent_packages` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `package_id` int COLLATE utf8_bin NOT NULL,
  `agent_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`package_id`) REFERENCES packages(`id`),
  FOREIGN KEY (`agent_id`) REFERENCES agent(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `properties_attempts`
--
CREATE TABLE IF NOT EXISTS `properties_attempts` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `point_count` int COLLATE utf8_bin NOT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `user_id` int COLLATE utf8_bin NOT NULL,
  `features_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`features_id`) REFERENCES features(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------