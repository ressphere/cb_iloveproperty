-- Extract from db/cb_db/full/cb_init_country.sql
-- With Additional of column
--      * currency_code  (https://en.wikipedia.org/wiki/ISO_4217)
--      * currency_name 
--      * flag_image 
INSERT INTO `country` (`name`, `country_code`, `currency_code`, `currency_name`) VALUES ("Malaysia", 60, "MYR", "Malaysian ringgit");
INSERT INTO `country` (`name`, `country_code`, `currency_code`, `currency_name`) VALUES ("Singapore", 65, "SGD", "Singapore dollar");
INSERT INTO `country` (`name`, `country_code`, `currency_code`, `currency_name`) VALUES ("United States", 1, "USD", "United States dollar");
INSERT INTO `country` (`name`, `country_code`, `currency_code`, `currency_name`) VALUES ("China", 86, "CNY", "Chinese yuan");


-- Extract from db/cb_db/full/cb_init_mmoble_code.sql
-- Modified base on the country_id changes
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)10", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)11", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)12", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)13", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)14", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)15", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)16", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)17", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)18", NULL, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)19", NULL, 1);

-- Extract from db/cb_db/full/cb_init_state_3.sql
-- Modified to include all state for Malaysia
-- *** Do aware that some state is missing for cb_init_state_3.sql for now
INSERT INTO `state` (`name`) VALUES ("Kuala Lumpur");
INSERT INTO `state` (`name`) VALUES ("Johor");
INSERT INTO `state` (`name`) VALUES ("Kedah");
INSERT INTO `state` (`name`) VALUES ("Kelantan");
INSERT INTO `state` (`name`) VALUES ("Malacca");
INSERT INTO `state` (`name`) VALUES ("Sembilan");
INSERT INTO `state` (`name`) VALUES ("Pahang");
INSERT INTO `state` (`name`) VALUES ("Perak");
INSERT INTO `state` (`name`) VALUES ("Perlis");
INSERT INTO `state` (`name`) VALUES ("Pulau Pinang");
INSERT INTO `state` (`name`) VALUES ("Sabah");
INSERT INTO `state` (`name`) VALUES ("Sarawak");
INSERT INTO `state` (`name`) VALUES ("Selangor");
INSERT INTO `state` (`name`) VALUES ("Terengganu");

-- Insert linkage for state and country
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (1, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (2, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (3, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (4, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (5, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (6, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (7, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (8, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (9, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (10, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (11, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (12, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (13, 1);
INSERT INTO `state_country` (`state_id`, `country_id`) VALUES (14, 1);


-- Extract from db/cb_db/full/cb_init_state_code_3.sql
-- Modified base on the country_id and state_id changes
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)3", 1, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)6", 2, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)7", 2, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)4", 3, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)9", 4, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)6", 5, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)6", 6, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)3", 7, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)9", 7, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)5", 7, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)5", 8, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)4", 9, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)4", 10, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)87", 11, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)88", 11, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)89", 11, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)81", 12, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)82", 12, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)83", 12, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)84", 12, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)85", 12, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)86", 12, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)3", 13, 1);
INSERT INTO `zone_phone` (`state_code`, `state_id`, `country_id`) VALUES ("(0)9", 13, 1);


