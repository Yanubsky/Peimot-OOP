<?php 
ini_set("display_errors", true); // keep true while debbuging, TODO: switch to false before going live
define('DB_DSN', "mysql:host=localhost:3307;dbname=peimot-class");  
define("DB_USERNAME", "yaniv");
define('DB_PASSWORD', 'Clinton55'); // TODO: hash() the password as explaind in the tutorial - https://www.elated.com/cms-in-an-afternoon-php-mysql/#step1
define('CLASS_PATH','classes');
define('TEMPLATE_PATH','templates');
define('ARTICLES_EXHIBIT_NUM', '5');
define('SITE_ROOT', __DIR__);
// require('helper-functions.php');    
// require( CLASS_PATH . "/Article.php");

?>