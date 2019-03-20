<?php
namespace Config;

Class DbParams
{
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