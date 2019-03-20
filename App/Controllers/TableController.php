<?php
namespace App\Controllers;

use App\Models\Link;

/**
 * Class TableController
 * @package App\Controllers
 */
class TableController
{
    /**
     * Create table.
     */
    public function actionCreate()
    {
        $table = new Link;
        echo ($table->createTable())? 'Таблица создана успешно' : 'Ошибка';
    }

    /**
     * Drop table.
     */
    public function actionDrop()
    {
        $table = new Link;
        echo ($table->dropTable())? 'Таблица успешно удалена' : 'Ошибка';
    }
}