-- --------------------------------------------------------

--
-- Table structure for table `map_location`
--
CREATE TABLE IF NOT EXISTS `map_location` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `street` varchar(100) COLLATE utf8_bin NOT NULL,
  `google_ip` varchar(100) COLLATE utf8_bin NOT NULL,
  `location_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`location_id`) REFERENCES location(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE IF NOT EXISTS `room_type` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `property_name`
--

CREATE TABLE IF NOT EXISTS `property_name` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE IF NOT EXISTS `property_type` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `tenure`
--

CREATE TABLE IF NOT EXISTS `tenure` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `type` enum('LEASE','FREE') COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `unit_type`
--

CREATE TABLE IF NOT EXISTS `unit_type` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `nearest_spot`
--

CREATE TABLE IF NOT EXISTS `nearest_spot` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `transportation`
--

CREATE TABLE IF NOT EXISTS `transportation` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `title_type`
--

CREATE TABLE IF NOT EXISTS `title_type` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `type` enum('BUMI_LOT','COMMERCIAL','RESIDENTIAL', 'ROOM', 'LAND', 'NEW_LAUNCHING') COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `properties_listing`
--

CREATE TABLE IF NOT EXISTS `properties_listing` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_bin,
  `phone` int COLLATE utf8_bin,
  `listing_type` enum('RENT','SELL') COLLATE utf8_bin NOT NULL,
  `price` decimal(10,2) COLLATE utf8_bin NOT NULL,
  `monthly_maintanance` decimal(10,2) COLLATE utf8_bin,
  `auction` boolean COLLATE utf8_bin,
  `buildup` int COLLATE utf8_bin,
  `landarea` int COLLATE utf8_bin,
  `bedrooms` int COLLATE utf8_bin NOT NULL,
  `bathrooms` int COLLATE utf8_bin NOT NULL,
  `ref` varchar(100) COLLATE utf8_bin NOT NULL,
  `furnished` boolean COLLATE utf8_bin NOT NULL,
  `occupied` boolean COLLATE utf8_bin NOT NULL,
  `remark` varchar(1000) COLLATE utf8_bin,
  `room_type_id` int COLLATE utf8_bin,
  `property_type_id` int COLLATE utf8_bin,
  `property_name_id` int COLLATE utf8_bin NOT NULL,
  `map_location_id` int COLLATE utf8_bin NOT NULL,
  `tenure_id` int COLLATE utf8_bin,
  `unit_type_id` int COLLATE utf8_bin,
  `title_type_id` int COLLATE utf8_bin,
  `transportation_id` int COLLATE utf8_bin,
  `active` boolean COLLATE utf8_bin NOT NULL,
  `user_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`room_type_id`) REFERENCES room_type(`id`),
  FOREIGN KEY (`property_type_id`) REFERENCES property_type(`id`),
  FOREIGN KEY (`property_name_id`) REFERENCES property_name(`id`),
  FOREIGN KEY (`map_location_id`) REFERENCES map_location(`id`),
  FOREIGN KEY (`tenure_id`) REFERENCES tenure(`id`),
  FOREIGN KEY (`unit_type_id`) REFERENCES unit_type(`id`),
  FOREIGN KEY (`title_type_id`) REFERENCES title_type(`id`),
  FOREIGN KEY (`transportation_id`) REFERENCES transportation(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `property_photo`
--

CREATE TABLE IF NOT EXISTS `property_photo` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `path` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` varchar(100) COLLATE utf8_bin NOT NULL,
  `property_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`property_id`) REFERENCES properties_listing(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `facilities_properties_listing`
--

CREATE TABLE IF NOT EXISTS `facilities_properties_listing` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `facilities_id` int COLLATE utf8_bin NOT NULL,
  `property_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`property_id`) REFERENCES properties_listing(`id`),
  FOREIGN KEY (`facilities_id`) REFERENCES facilities(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `facilities_properties_listing`
--

CREATE TABLE IF NOT EXISTS `nearest_spot_listing` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `spot_id` int COLLATE utf8_bin NOT NULL,
  `property_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`property_id`) REFERENCES properties_listing(`id`),
  FOREIGN KEY (`spot_id`) REFERENCES nearest_spot(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `property_photo`
--

CREATE TABLE IF NOT EXISTS `property_photo` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `path` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` varchar(100) COLLATE utf8_bin NOT NULL,
  `property_id` int COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`property_id`) REFERENCES properties_listing(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------