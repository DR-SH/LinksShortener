<?php
namespace App\Components;

use Config\DbParams;
use PDO;

class Db
{

    public static function connect()
	{
        $params= DbParams::get();
        $db = new PDO("mysql:host={$params['host']};dbname={$params['dbname']}",
                        $params['user'],
                        $params['password'] );

        $db->exec("set names utf8"); // Задаем кодировку

        return $db;
    }
}