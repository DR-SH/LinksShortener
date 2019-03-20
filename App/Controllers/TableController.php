<?php
namespace App\Controllers;

use App\Models\Link;


class TableController
{
    public function create()
    {
        $table = new Link;
        $table->createTable();
    }
}