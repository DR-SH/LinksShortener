<?php
namespace App;

//Общие найстройки
ini_set('display_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);
session_start();

//Автозагрузка
define('ROOT', dirname(__FILE__));
require ROOT.'/Vendor/autoload.php';

//Вызов роутера
$router = new Components\Router;
$router->run();
?>

