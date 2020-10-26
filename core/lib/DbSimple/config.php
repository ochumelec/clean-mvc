<?php
if (!defined("PATH_SEPARATOR")) {
    define("PATH_SEPARATOR", getenv("COMSPEC") ? ";" : ":");
}
ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . dirname(__FILE__));

require_once(dirname(__FILE__) . "/Generic.php");
require_once(dirname(__FILE__) . "/../../conf/config.php");

// Подключаемся к БД.
$DATABASE = DbSimple_Generic::connect('postgresql://' . \conf\Dbconfig::$_user . ':' . \conf\Dbconfig::$_pass . '@' . \conf\Dbconfig::$_host . '/' . \conf\Dbconfig::$_db . '');

// Устанавливаем обработчик ошибок.
$DATABASE->setErrorHandler('databaseErrorHandler');

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{

// Если использовалась @, ничего не делать.
//    if (!error_reporting()) {
//        return;
//    }else{
//        throw new Exception('DbError');
//    }


// Выводим подробную информацию об ошибке.
    echo "SQL Error: $message <pre>";
    print_r($info);
    echo "</pre>";
    exit();
}

?>