<?php

namespace Lavi\Model;

class GenericModel extends DBConnector
{
    protected string $mainTableName;

    public function __constructor()
    {
        parent::__constructor();
    }

    protected function setMainTableName(string $tableName): void
    {
        $this->mainTableName = $tableName;
    }

    protected function withTable(string $tableName, callable $func)
    {
        $currentTable = $this->mainTableName;

        $this->mainTableName = $tableName;
        $result = $func();
        $this->mainTableName = $currentTable;

        return $result;
    }

    public function db(): ?DBConnector
    {
        return $this->getConnection();
    }
}