-- --------------------------------------------------------

--
-- Table structure for table `CB_Home_category`
--

CREATE TABLE IF NOT EXISTS `CB_Home_category` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `category` varchar(100) COLLATE utf8_bin NOT NULL,
  `category_path` varchar(300) NOT NULL,
  `category_icon`  varchar(300) NOT NULL,
  `category_mo_icon`  varchar(300) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `CB_Home_about_us`
--

CREATE TABLE IF NOT EXISTS `CB_Home_about_us` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `content` LONGTEXT COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `CB_Home_video`
--

CREATE TABLE IF NOT EXISTS `CB_Home_video` (
  `id` int COLLATE utf8_bin AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_bin NOT NULL,
  `content_path` varchar(300) NULL,
  `content_display_path` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `currency_converter`
--
CREATE TABLE IF NOT EXISTS `currency_converter` (
   `id` int COLLATE utf8_bin AUTO_INCREMENT PRIMARY KEY,
   `from`  varchar(100) COLLATE utf8_bin NOT NULL,
   `to`  varchar(100) COLLATE utf8_bin NOT NULL,
   `rates` float,
   `created` datetime,
   `modified` datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- --------------------------------------------------------

