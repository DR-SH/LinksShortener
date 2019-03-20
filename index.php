<?php
namespace App;

//Общие найстройки
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//Подключение файлов системы

define('ROOT', dirname(__FILE__));
require ROOT.'/Vendor/autoload.php';
require_once (ROOT.'/App/Components/Db.php');
//require_once  (ROOT.'/models/Link.php');
//Соединение с БД
//Вызов роутера
$router = new Components\Router;
$router->run();
?>

