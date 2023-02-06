<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-03-16 14:59:00 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: NO) /var/www/vhosts/kwebmakerdigitalagency.com/httpdocs/scanapp/system/database/drivers/mysqli/mysqli_driver.php 201
ERROR - 2022-03-16 14:59:01 --> Unable to connect to the database
ERROR - 2022-03-16 15:03:03 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: NO) /var/www/vhosts/kwebmakerdigitalagency.com/httpdocs/scanapp/system/database/drivers/mysqli/mysqli_driver.php 201
ERROR - 2022-03-16 15:03:03 --> Unable to connect to the database
ERROR - 2022-03-16 15:07:03 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'kwebscanappuser'@'localhost' (using password: YES) /var/www/vhosts/kwebmakerdigitalagency.com/httpdocs/scanapp/system/database/drivers/mysqli/mysqli_driver.php 201
ERROR - 2022-03-16 15:07:03 --> Unable to connect to the database
ERROR - 2022-03-16 15:07:28 --> Query error: Table 'kweb-scanapp-db.ci_sessions' doesn't exist - Invalid query: SELECT `data`
FROM `ci_sessions`
WHERE `id` = '3646q0sbagvqk2r47m4397lqdal8iq82'
ERROR - 2022-03-16 15:07:28 --> Severity: Warning --> session_write_close(): Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2022-03-16 15:07:28 --> Severity: Warning --> session_write_close(): Failed to write session data using user defined save handler. (session.save_path: /var/lib/php/session) Unknown 0
