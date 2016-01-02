-- This SQL is to insert all structure related to property listing
-- Following table structure will be created
--      map_location
--      property_name
--      property_type
--      tenure
--      reserve_type
--      land_title_type
--      furnished_type
--      properties_listing
--      facilities
--      facilities_properties_listing
--      property_photo
--      properties_ref

-- --------------------------------------------------------
--
-- Table structure for table `map_location`
--
CREATE TABLE IF NOT EXISTS `map_location` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `street` varchar(100) COLLATE utf8_bin,
    `map_location` varchar(100) COLLATE utf8_bin NOT NULL,
    `location_id` int COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`location_id`) REFERENCES location(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `property_name`
--
CREATE TABLE IF NOT EXISTS `property_name` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `property_name` varchar(100) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `property_type`
--
CREATE TABLE IF NOT EXISTS `property_type` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `property_category` varchar(100) COLLATE utf8_bin NOT NULL,
    `property_type` varchar(100) COLLATE utf8_bin NOT NULL,
    `service_type` varchar(100) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `tenure`
--
CREATE TABLE IF NOT EXISTS `tenure` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `tenure` varchar(100) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `reserve_type`
--
CREATE TABLE IF NOT EXISTS `reserve_type` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `reserve_type` varchar(100) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `land_title_type`
--
CREATE TABLE IF NOT EXISTS `land_title_type` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `land_title_type` varchar(100) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `furnished_type`
--
CREATE TABLE IF NOT EXISTS `furnished_type` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `furnished_type` varchar(100) COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `properties_listing`
--
CREATE TABLE IF NOT EXISTS `properties_listing` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `activate` boolean NOT NULL,
    `activate_time` datetime NOT NULL,
    `auction` datetime,
    `bathrooms` int COLLATE utf8_bin,
    `bedrooms` int COLLATE utf8_bin,
    `car_park` int COLLATE utf8_bin,
    `buildup` float COLLATE utf8_bin,
    `create_time` datetime NOT NULL,
    `edit_time` datetime NOT NULL,
    `landarea` float COLLATE utf8_bin,
    `monthly_maintanance` decimal(10,2) COLLATE utf8_bin,
    `occupied` boolean COLLATE utf8_bin NOT NULL,
    `currency` varchar(10) COLLATE utf8_bin NOT NULL,
	`size_measurement_code` varchar(10) COLLATE utf8_bin NOT NULL,
    `price` decimal(10,2) COLLATE utf8_bin NOT NULL,
    `ref_tag` varchar(100) COLLATE utf8_bin NOT NULL,
    `remark` varchar(1000) COLLATE utf8_bin,
    `land_title_type_id` int COLLATE utf8_bin,
    `map_location_id` int COLLATE utf8_bin NOT NULL,
    `property_name_id` int COLLATE utf8_bin NOT NULL,
    `property_type_id` int COLLATE utf8_bin,
    `reserve_type_id` int COLLATE utf8_bin,
    `tenure_id` int COLLATE utf8_bin,
    `furnished_type_id` int COLLATE utf8_bin,
    `user_id` int COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`land_title_type_id`) REFERENCES land_title_type(`id`),
    FOREIGN KEY (`map_location_id`) REFERENCES map_location(`id`),
    FOREIGN KEY (`property_name_id`) REFERENCES property_name(`id`),
    FOREIGN KEY (`property_type_id`) REFERENCES property_type(`id`),
    FOREIGN KEY (`reserve_type_id`) REFERENCES reserve_type(`id`),
    FOREIGN KEY (`tenure_id`) REFERENCES tenure(`id`),
    FOREIGN KEY (`furnished_type_id`) REFERENCES furnished_type(`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
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
-- Table structure for table `property_photo`
--
CREATE TABLE IF NOT EXISTS `property_photo` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `path` varchar(300) COLLATE utf8_bin NOT NULL,
    `description` varchar(100) COLLATE utf8_bin,
    `property_id` int COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`property_id`) REFERENCES properties_listing(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `properties_ref` and sequence
--
CREATE TABLE IF NOT EXISTS `properties_ref` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `category` varchar(100) COLLATE utf8_bin NOT NULL,
    `prefix` varchar(100) COLLATE utf8_bin NOT NULL,
    `number` int COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------