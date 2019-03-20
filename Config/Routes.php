<?php
namespace Config;

/**
 * Class Routes
 * @package Config
 */
Class Routes
{
    /**
     * Routes for router.
     * 
     * @return array
     */
    public static function get()
    {
        return [
            //'table/create' => 'table/create',  // actionCreate in TableController
            // 'table/drop' => 'table/drop',  // actionDrop in TableController
            'create' => 'link/create', // actionCreate in LinkController
            '([a-z0-9]+)' => 'link/get/$1', // actionGet in LinkController
            '/' => 'link/index' // actionIndex in LinkController
        ];
    }
}
