<?php
namespace Config;

/**
 * Class DbParams
 * @package Config
 */
Class DbParams
{
    /**
     * Database settings.
     *
     * @return array
     */
    public static function get()
    {
        return [
          'host' => 'localhost',
          'dbname' => 'test4',
          'user' => 'homestead',
          'password' => 'secret'
        ];
    }
}