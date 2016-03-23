-- This SQL is to insert all structure related to user profile
-- Following table structure will be created
--      1. area
--      2. country
--      3. state
--      4. zone_phone
--      5. users
--      6. property_info
--      7. ci_sessions
--      8. login_attempts
--      9. user_autologin
--      10. user_profiles
--      11. location
--      12. state_country


-- --------------------------------------------------------
--
-- Table structure for table `area`
--
CREATE TABLE IF NOT EXISTS `area` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `country`
--
CREATE TABLE IF NOT EXISTS `country` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin UNIQUE,
  `country_code` int COLLATE utf8_bin,
  `longitude` double COLLATE utf8_bin UNIQUE,
  `latitude` double COLLATE utf8_bin UNIQUE,
  `flag_image` varchar(300) COLLATE utf8_bin,
  `currency_code` varchar(10) COLLATE utf8_bin,
  `currency_name` varchar(100) COLLATE utf8_bin,
  `currency_image` varchar(300) COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `state`
--
CREATE TABLE IF NOT EXISTS `state` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `zone_phone`
--
CREATE TABLE IF NOT EXISTS `zone_phone` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `state_code` varchar(100) COLLATE utf8_bin NOT NULL,
  `state_id` int COLLATE utf8_bin,
  `country_id` int COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`state_id`) REFERENCES `state`(`id`),
  FOREIGN KEY (`country_id`) REFERENCES country(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `displayname` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `oldpassword` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(200) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `agent`   TINYINT(1) NOT NULL DEFAULT '0',
  `country_id` int COLLATE utf8_bin NOT NULL DEFAULT '1',
  `prop_listing_limit` int COLLATE utf8_bin DEFAULT '3',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`country_id`) REFERENCES country(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `property_info`
--
CREATE TABLE IF NOT EXISTS `property_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Price` double NOT NULL,
  `Property_info_image` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `ci_sessions`
--
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `login_attempts`
--
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `user_autologin`
--
CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `user_profiles`
--
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- Table structure for table `location`
--
CREATE TABLE IF NOT EXISTS `location` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `post_code` varchar(100) COLLATE utf8_bin NOT NULL,
  `area_id` int COLLATE utf8_bin DEFAULT NULL,
  `state_country_id` int COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`area_id`) REFERENCES area(`id`),
  FOREIGN KEY (`state_country_id`) REFERENCES `state`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- Table structure for table `state_country`
--
CREATE TABLE IF NOT EXISTS `state_country` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `state_id` int COLLATE utf8_bin,
  `country_id` int COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`state_id`) REFERENCES `state`(`id`),
  FOREIGN KEY (`country_id`) REFERENCES `country`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

delimiter //
CREATE TRIGGER upd_users_pw BEFORE UPDATE ON users
    FOR EACH ROW
    BEGIN
        IF NEW.password != OLD.password THEN
            SET NEW.oldpassword = OLD.password;
         END IF;
    END;//
delimiter ;
-- --------------------------------------------------------