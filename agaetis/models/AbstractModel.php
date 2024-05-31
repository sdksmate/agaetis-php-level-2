<?php

namespace agaetis\models;

use agaetis\services\StorageFactory;

use \PDO;

/**
 * 
 * @author Arvind Sharma
 */
abstract class AbstractModel
{

    public function __construct()
    {
        $this->prepareStore();
    }

    abstract protected function prepareStore();

    public function exec($sql, $param = null)
    {
        $db = StorageFactory::getSession();
        $stmt = $db->prepare($sql);
        $res = $stmt->execute($param);
        return $res;
    }

    public function fetchAll($sql, $param = null, $mode = null)
    {
        $db = StorageFactory::getSession();
        $rows = null;
        if (!$mode) {
            $mode = PDO::FETCH_ASSOC;
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($param);
        $stmt->setFetchMode($mode);
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        return $rows;
    }
}
