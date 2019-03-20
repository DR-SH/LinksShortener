<?php
namespace Config;

Class Routes
{
    public static function get()
    {
        return [
            'create' => 'link/create', // actionCreate в LinkController
            '([a-z0-9]+)' => 'link/show/$1', // actionShow в LinkController
            '' => 'link/index' // actionIndex в LinkController

        ];
    }

}
