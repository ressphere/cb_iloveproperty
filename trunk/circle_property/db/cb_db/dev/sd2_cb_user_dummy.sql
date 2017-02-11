-- This sql contain dummy user, which cutshort the setup procedure
--
-- User name : test@yahoo.com
-- Password : qweasd

INSERT INTO `users` (`id`, `username`, `displayname`, `password`, `phone`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `country_id`, prop_listing_limit, `modified`) VALUES (1, 'test@yahoo.com', 'test', '$2a$08$CN.qXYaWQ1sJiV8795mYveQv290a97N2ZccPAIwhjSom79fh6G3j.', '60124566751', 'test@yahoo.com', 1, 0, NULL, NULL, NULL, NULL, 'f82e425836d0fa6b5fb82c855c47b5b7', '::1', '2015-01-17 18:08:04', '2015-01-17 13:45:19', 1, 3, '2015-01-17 10:08:04');
