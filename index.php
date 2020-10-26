<?php
if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == 'dev') {
    ini_set('display_errors', true);
    ini_set('error_reporting', E_ALL);
} else {
    ini_set('display_errors', false);
}

//header('Content-Type: text/html; charset=utf-8');

require_once(dirname(__FILE__) . '/core/router.php');

$obj= new \core\Router();
$obj->run();

?>