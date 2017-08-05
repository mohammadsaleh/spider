<?php
namespace Spider\Lib;

use Cake\ORM\TableRegistry;

trait StatusTrait
{
    protected function _changeStatusTo($newStatus , $table , $id)
    {
        $TableInfo = TableRegistry::get($table);
        return $TableInfo->updateAll(['status' => $newStatus], ['id' => $id]);
    }

    protected function getStatus($table , $id)
    {
        $TableInfo = TableRegistry::get($table);
        $status = $TableInfo->find()
            ->where(['id' => $id])
            ->first();
        return $status;
    }
}