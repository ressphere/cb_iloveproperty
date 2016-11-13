DELIMITER $$
DROP TRIGGER IF EXISTS `iloveproperties_db`.`upd_users_info` $$
CREATE TRIGGER upd_users_info BEFORE UPDATE ON users
    FOR EACH ROW
    BEGIN
        IF NEW.password != OLD.password THEN
            SET NEW.oldpassword = OLD.password;
        END IF;
        IF NEW.banned != OLD.banned THEN
            IF NEW.banned = '1' THEN
                UPDATE properties_listing
                SET `properties_listing`.`activate`='0'
                WHERE `properties_listing`.`user_id` = NEW.id;
            END IF;
        END IF;
    END; $$
DELIMITER ;


DELIMITER $$
DROP TRIGGER IF EXISTS `iloveproperties_db`.`upd_properties_info` $$
CREATE TRIGGER upd_properties_info BEFORE UPDATE ON properties_listing
    FOR EACH ROW
    BEGIN
        DECLARE banned_status INTEGER;
        IF NEW.activate != OLD.activate THEN
            IF NEW.activate = '1' THEN
                SELECT users.banned INTO @banned_status FROM users WHERE users.id = NEW.user_id;
                IF @banned_status = '1' THEN
                    SET NEW.activate = '0';
                END IF;
            END IF;
        END IF;
    END;$$
DELIMITER ;


DELIMITER $$

DROP PROCEDURE IF EXISTS `iloveproperties_db`.`prop_listing_limit_controller` $$
CREATE PROCEDURE `iloveproperties_db`.`prop_listing_limit_controller` (
    IN User_Id INT,
    IN Subscribed_Limit INT,
    OUT NewListingCount INT,
    OUT Done INT)
  MODIFIES SQL DATA
BEGIN
  DECLARE Done INTEGER DEFAULT 0;
  DECLARE NewListingCount, OldListingCount INTEGER DEFAULT 3;
  DECLARE EXIT HANDLER FOR NOT FOUND SET Done = -1;

  SELECT `users`.`prop_listing_limit` INTO OldListingCount FROM `users` WHERE `users`.`id` = User_Id;
  SET NewListingCount = OldListingCount + Subscribed_Limit;
  IF  NewListingCount >= 3 THEN
    UPDATE `users` SET `users`.`prop_listing_limit` = NewListingCount WHERE `users`.`id` = User_Id;
  ELSE
    SET NewListingCount = 3;
    UPDATE `users` SET `users`.`prop_listing_limit` = NewListingCount WHERE `users`.`id` = User_Id;
  END IF;
END $$
DELIMITER ;


DELIMITER $$
DROP TRIGGER IF EXISTS `iloveproperties_db`.`ins_listing_subcription` $$
CREATE TRIGGER ins_listing_subcription BEFORE INSERT ON listing_subcription
    FOR EACH ROW
    BEGIN
        DECLARE Done INTEGER DEFAULT 0;
        DECLARE NewListingCount,OldListingCount  INTEGER DEFAULT 0;
        CALL prop_listing_limit_controller(
          New.user_id,
          NEW.number_of_listing,
          NewListingCount,
          Done);
    END $$
delimiter ;

DELIMITER $$
DROP TRIGGER IF EXISTS `iloveproperties_db`.`del_listing_subcription` $$
CREATE TRIGGER del_listing_subcription BEFORE DELETE ON listing_subcription
    FOR EACH ROW
    BEGIN
        DECLARE Done INTEGER DEFAULT 0;
        DECLARE Number_Of_Deleted_Listing INTEGER DEFAULT 0;
        DECLARE NewListingCount, OldListingCount INTEGER DEFAULT 0;

        SET Number_Of_Deleted_Listing = -OLD.number_of_listing;
        CALL prop_listing_limit_controller(
          OLD.user_id,
          Number_Of_Deleted_Listing,
          NewListingCount,
          Done);
        IF Done = 0 THEN
             CALL Deactivate_Listing_By_Count(OLD.user_id, NewListingCount);
        END IF;
    END $$
delimiter ;

DELIMITER $$
DROP TRIGGER IF EXISTS `iloveproperties_db`.`upd_listing_subcription` $$
CREATE TRIGGER upd_listing_subcription BEFORE UPDATE ON listing_subcription
    FOR EACH ROW
    BEGIN
        DECLARE Done INTEGER DEFAULT 0;
        DECLARE Number_Of_Remained_Listing INTEGER DEFAULT 0;
        DECLARE NewListingCount, OldListingCount INTEGER DEFAULT 0;

        SET Number_Of_Remained_Listing = NEW.number_of_listing - OLD.number_of_listing;
        CALL prop_listing_limit_controller(
          New.user_id,
          Number_Of_Remained_Listing,
          NewListingCount,
          Done);
        IF Done = 0 THEN
             CALL Deactivate_Listing_By_Count(OLD.user_id, NewListingCount);
        END IF;
    END $$
delimiter ;

DELIMITER $$

DROP PROCEDURE IF EXISTS `iloveproperties_db`.`Deactivate_Listing_By_Count` $$
CREATE PROCEDURE `iloveproperties_db`.`Deactivate_Listing_By_Count` (
    IN User_Id INT,
    IN NewListingCount INT
  )
BEGIN
    DECLARE l_last_row_fetched, l_prop_id INT DEFAULT 0;
    DECLARE l_prop_activate_time 	datetime;
    DECLARE l_prop_count,  l_deactivate_listing_count INT DEFAULT 0;

    DECLARE c_listing CURSOR FOR SELECT `properties_listing`.`id`, `properties_listing`.`activate_time` FROM
    `properties_listing` WHERE
    `properties_listing`.`user_id` = User_Id
    and `properties_listing`.`activate` = 1 Order By `properties_listing`.`activate` ASC;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET l_last_row_fetched=1;

    SELECT COUNT(*) INTO l_prop_count FROM `properties_listing` WHERE
    `properties_listing`.`user_id` = User_Id and `properties_listing`.`activate` = 1;

    IF l_prop_count >  NewListingCount THEN
      SET l_deactivate_listing_count = l_prop_count -  NewListingCount;
      OPEN c_listing;
        cursor_loop: LOOP
            FETCH c_listing INTO l_prop_id, l_prop_activate_time;
                IF l_last_row_fetched=1 or l_deactivate_listing_count <= 0 THEN
                LEAVE cursor_loop;
              ELSE
                UPDATE `properties_listing` SET `properties_listing`.`activate` = 0 WHERE
                `properties_listing`.`id` = l_prop_id;
                SET l_deactivate_listing_count = l_deactivate_listing_count - 1;
              END IF;
        END LOOP cursor_loop;
      CLOSE c_listing;
    END IF;

END $$
DELIMITER ;