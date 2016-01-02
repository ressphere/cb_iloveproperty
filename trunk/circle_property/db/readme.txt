Sequence to import db table
---------------------------
1. Create database iloveproperties_db
2. Setup require data structure
    a.  db/s1_fuel_schema.sql              (Fuelcms data structure and necessary data)
    b.  db/cb_db/s2_cb_user.sql            (Ressphere user login structure)
    c.  db/cb_db/s3_cb_home.sql            (Ressphere home page structure)
    d.  db/cb_db/s4_cb_properties_agent.sql        (Ressphere properties agent structure)
    d.  db/cb_db/s5_cb_properties_listing.sql      (Ressphere properties listing structure)

3. Load require data
    a.  db/cb_db/s6_cb_init.sql                    (Ressphere homepage default value)
    b.  db/cb_db/s7_cb_properties_preload_data.sql (Ressphere properties initial data)

4. Load development dummy datafor Ressphere property, don't do it if want to load complete data set
   * Must follow sequence if other country loaded, due to country id hard coded
    a.  db/cb_db/dev/sd1_cb_init_malaysia_data.sql  (country, state and model code for Malaysia)
    b.  db/cb_db/dev/sd2_cb_user_dummy.sql          (Optional, just to skip the register process)(user:test@yahoo.com. pass:qweasd)

5. Load complete data for Ressphere property (cause long run)
   ** Do aware that i spot the mapping for the state code is incorrect (like 04 state code currently tie to selangor ... lol)
   ** Do aware that the state is missing (like Penang not found.... OMG)
    a.  db/cb_db/full/cb_init_country.sql
    b.  db/cb_db/full/cb_init_mobile_code.sql
    c.  db/cb_db/full/cb_init_state_1.sql
    d.  db/cb_db/full/cb_init_state_2.sql
    e. db/cb_db/full/cb_init_state_3.sql
    f. db/cb_db/full/cb_init_state_4.sql
    g. db/cb_db/full/cb_init_state_code_1.sql
    h. db/cb_db/full/cb_init_state_code_2.sql
    i. db/cb_db/full/cb_init_state_code_3.sql
    j. db/cb_db/full/cb_init_state_code_4.sql

6. Extension need to be enable in php.ini (place under "<xampp install path>/php" )
    - remove the ";" to enable extension=php_openssl.dll