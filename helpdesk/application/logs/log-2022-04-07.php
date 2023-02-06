<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-04-07 12:46:56 --> Severity: error --> Exception: Argument 1 passed to CI_Form_validation::set_data() must be of the type array, null given, called in C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php on line 64 C:\wamp64\www\scanapp\system\libraries\Form_validation.php 267
ERROR - 2022-04-07 12:47:14 --> Severity: error --> Exception: Argument 1 passed to CI_Form_validation::set_data() must be of the type array, null given, called in C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php on line 64 C:\wamp64\www\scanapp\system\libraries\Form_validation.php 267
ERROR - 2022-04-07 12:48:10 --> Severity: error --> Exception: Argument 1 passed to CI_Form_validation::set_data() must be of the type array, null given, called in C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php on line 64 C:\wamp64\www\scanapp\system\libraries\Form_validation.php 267
ERROR - 2022-04-07 12:48:20 --> Severity: error --> Exception: Argument 1 passed to CI_Form_validation::set_data() must be of the type array, null given, called in C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php on line 64 C:\wamp64\www\scanapp\system\libraries\Form_validation.php 267
ERROR - 2022-04-07 12:49:31 --> Severity: error --> Exception: Argument 1 passed to CI_Form_validation::set_data() must be of the type array, null given, called in C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php on line 64 C:\wamp64\www\scanapp\system\libraries\Form_validation.php 267
ERROR - 2022-04-07 12:50:38 --> Severity: error --> Exception: Class 'JWT' not found C:\wamp64\www\scanapp\application\modules\security\controllers\Security.php 110
ERROR - 2022-04-07 13:07:13 --> Severity: Notice --> Undefined property: stdClass::$type C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php 113
ERROR - 2022-04-07 13:07:13 --> Severity: Notice --> Undefined property: stdClass::$uid C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php 114
ERROR - 2022-04-07 13:07:13 --> Query error: Table 'scanapp.authentication' doesn't exist - Invalid query: SELECT *
FROM `authentication`
WHERE `registration_id` = '1'
AND `type` IS NULL
AND `uid` IS NULL
ERROR - 2022-04-07 17:59:10 --> Severity: Notice --> Undefined property: stdClass::$type C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php 135
ERROR - 2022-04-07 17:59:10 --> Query error: Column 'type' cannot be null - Invalid query: INSERT INTO `authentication` (`name`, `mobile`, `email`, `parent_id`, `type`) VALUES ('Santosh Shrikhande', '9834797281', 'santosh@kwebmaker.com', '1', NULL)
ERROR - 2022-04-07 18:00:48 --> Severity: Notice --> Undefined variable: type C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php 163
ERROR - 2022-04-07 18:00:48 --> Query error: Column 'type' cannot be null - Invalid query: INSERT INTO `authentication` (`name`, `mobile`, `email`, `parent_id`, `type`) VALUES ('Santosh Shrikhande', '9834797281', 'santosh@kwebmaker.com', '1', NULL)
ERROR - 2022-04-07 18:02:11 --> Query error: Unknown column 'organization' in 'where clause' - Invalid query: UPDATE `authentication` SET `id` = 1
WHERE `token` = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOjF9.YNc8rGYj2liwqzVDKwzZLlft2aU2Pfkv58DTQ7Hk0rY'
AND `access` = 'both'
AND `name` = 'Kwebmaker '
AND `organization` = 'Kwebmaker '
AND `expiry_time` = '2022-04-08 18:02:11'
AND `created_date` = '2022-04-07 18:02:11'
AND `modified_date` = '2022-04-07 18:02:11'
ERROR - 2022-04-07 18:05:19 --> Severity: Notice --> Undefined index: id C:\wamp64\www\scanapp\application\modules\api\controllers\Auth.php 143
ERROR - 2022-04-07 19:33:08 --> Severity: Notice --> Array to string conversion C:\wamp64\www\scanapp\application\modules\generic\controllers\Generic.php 304
ERROR - 2022-04-07 19:43:03 --> Severity: Notice --> Undefined index: authtoken C:\wamp64\www\scanapp\application\modules\generic\controllers\Generic.php 311
