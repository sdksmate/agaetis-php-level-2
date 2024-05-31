<?php
namespace agaetis\services;

use agaetis\constants\Config;
use \PDO;

/**
 * 
 * @author Arvind Sharma
 * only single connection to db
 */
final class StorageFactory implements Config
{

    private function __construct()
    {}

    public static function getSession()
    {
        static $db = null;
        if (null === $db) {
            $db = new PDO(self::STORE_DRIVER . ':' . self::STORE_PATH);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
}
