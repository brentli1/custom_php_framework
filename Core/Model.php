<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 * 
 * PHP version 7.1.9
 */
class Model
{
    /**
     * Get the PDO database connection
     *
     * @return mixed
     **/
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $db = new PDO('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME, Config::DB_USER, Config::DB_PASS);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}
