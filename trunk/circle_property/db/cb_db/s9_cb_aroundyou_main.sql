-- This SQL is to insert all structure related to aroundyou
-- Following table structure will be created
--      aroundyou_map_location
--      aroundyou_benefit
--      aroundyou_company_type
--      aroundyou_product
--      aroundyou_operation_period
--      aroundyou_company
--      aroundyou_users
--      aroundyou_link_company_benefit

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_map_location`
--
CREATE TABLE IF NOT EXISTS `aroundyou_map_location` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `property_name` varchar(100) COLLATE utf8_bin,
    `street` varchar(100) COLLATE utf8_bin,
    `map_location` varchar(100) COLLATE utf8_bin NOT NULL,
    `location_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`location_id`) REFERENCES location(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_benefit`
--
CREATE TABLE IF NOT EXISTS `aroundyou_benefit` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_benefit__img` varchar(300) COLLATE utf8_bin,
    `aroundyou_benefit__title` varchar(100) COLLATE utf8_bin,
    `aroundyou_benefit__info` varchar(1000) COLLATE utf8_bin,
    `aroundyou_benefit__start_date` date DEFAULT NULL,
    `aroundyou_benefit__end_date` date DEFAULT NULL,
    `aroundyou_benefit__type` varchar(100) COLLATE utf8_bin,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_company_type`
--
CREATE TABLE IF NOT EXISTS `aroundyou_company_type` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_company_type__main_category` varchar(100) COLLATE utf8_bin,
    `aroundyou_company_type__sub_category` varchar(100) COLLATE utf8_bin,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_product`
--
CREATE TABLE IF NOT EXISTS `aroundyou_product` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_product__img` varchar(300) COLLATE utf8_bin,
    `aroundyou_product__title` varchar(50) COLLATE utf8_bin,
    `aroundyou_product__info` varchar(200) COLLATE utf8_bin,
    `aroundyou_product__price` int unsigned,
    `aroundyou_product__currency_code` varchar(100) COLLATE utf8_bin,
    `aroundyou_company_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`aroundyou_company_id`) REFERENCES aroundyou_company(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_operation_period`
--
CREATE TABLE IF NOT EXISTS `aroundyou_operation_period` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_operation_period__display` varchar(100) COLLATE utf8_bin,
    `aroundyou_operation_period__type` varchar(25) COLLATE utf8_bin,
    `aroundyou_operation_period__one_time` tinyint(1),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_company`
--
CREATE TABLE IF NOT EXISTS `aroundyou_company` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_company__logo` varchar(300) COLLATE utf8_bin,
    `aroundyou_company__phone` varchar(200) COLLATE utf8_bin,
    `aroundyou_company__fax` varchar(200) COLLATE utf8_bin,
    `aroundyou_company__email` varchar(100) COLLATE utf8_bin,
    `aroundyou_company_type_id` int NOT NULL,
    `aroundyou_operation_period_id` int NOT NULL,
    `aroundyou_company__operation_time_start` time,
    `aroundyou_company__operation_time_end` time,
    `aroundyou_company__operation_auto` tinyint(1),
    `aroundyou_company__operation_manual_date_start` date default NULL,
    `aroundyou_company__detail_head_pic` varchar(300) COLLATE utf8_bin,
    `aroundyou_company__about_us_intro` varchar(1000) COLLATE utf8_bin,
    `aroundyou_company__product_count_limit` int default 20,
    `aroundyou_company__benefit_count_limit` int default 5,
    `aroundyou_map_location_id` int NOT NULL,
    `aroundyou_company__modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `aroundyou_users_id` int NOT NULL,
    `aroundyou_company__activated` tinyint(1) NOT NULL DEFAULT '1',
    `aroundyou_company__activate_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `aroundyou_company__duration` int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`aroundyou_users_id`) REFERENCES aroundyou_users(`id`),
    FOREIGN KEY (`aroundyou_company_type_id`) REFERENCES aroundyou_company_type(`id`),
    FOREIGN KEY (`aroundyou_operation_period_id`) REFERENCES aroundyou_operation_period(`id`),
    FOREIGN KEY (`aroundyou_map_location_id`) REFERENCES aroundyou_map_location(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_users`
--
CREATE TABLE IF NOT EXISTS `aroundyou_users` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_users__activated` tinyint(1) NOT NULL DEFAULT '1',
    `aroundyou_users__banned` tinyint(1) NOT NULL DEFAULT '0',
    `aroundyou_users__ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
    `aroundyou_users__company_count_limit` int NOT NULL DEFAULT '1',
    `users_id` int NOT NULL,
    `aroundyou_users__modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`users_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `aroundyou_link_company_benefit`
--
CREATE TABLE IF NOT EXISTS `aroundyou_link_company_benefit` (
    `id` int COLLATE utf8_bin AUTO_INCREMENT,
    `aroundyou_company_id` int NOT NULL,
    `aroundyou_benefit_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`aroundyou_company_id`) REFERENCES aroundyou_company(`id`),
    FOREIGN KEY (`aroundyou_benefit_id`) REFERENCES aroundyou_benefit(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------
