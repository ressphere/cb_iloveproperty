delimiter //
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
    END;//
delimiter ;

delimiter //
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
    END;//
delimiter ;

