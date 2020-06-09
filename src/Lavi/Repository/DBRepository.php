<?php

namespace Lavi\Repository;

class DBRepository
{
    const METHOD_PREFIX = 'do';

    protected static $statement = null;
    protected $connection = null;
    protected $table      = null;

    private static $database  = null;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                'mysql:dbname='.Config::get('DB_NAME').
                ';host='.Config::get('DB_HOST').';charset='.Config::get('DB_CHARSET'),
                Config::get('DB_USER'),
                Config::get('DB_PASS')
            );

            $this->connection->setAttribute(
                PDO::ATTR_EMULATE_PREPARES, false
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
        } catch (\PDOException $exception) {
            throw new \Exception('Fill in the database access and roll the dump in the /dump folder!');
        }

        if (!$this->table) {
            $selfReflection = new \ReflectionClass(static::class);
            $this->table = strtolower($selfReflection->getShortName());
        }
    }

    public static function __callStatic($name, $arguments)
    {
        $methodName = static::METHOD_PREFIX.ucfirst($name);

        return (new static())->{$methodName}(...$arguments);
    }

    public static function getTable()
    {
        return (new static())->getTableName();
    }

    public function getTableName()
    {
        return $this->table;
    }

    public function getConnection()
    {
        if (static::$database === null) {
            static::$database = new self();
        }

        return static::$database;
    }

    public function doPrepare(string $query)
    {
        static::$statement = $this->connection->prepare($query);
    }

    public function doPagination(int $offset, int $limit, ?array $where = null, ?string $orderBy = null)
    {
        if ($orderBy) {
            $orderBy = 'ORDER BY '.$orderBy;
        }

        $sql = "SELECT * FROM ".$this->table." ".$where." ".$orderBy.
            " LIMIT ".$offset.", ".$limit;

        $this->doPrepare($sql);
        $this->doExecute();

        $items   = $this->fetchAllAssociative();
        $count   = $this->countAll();
        $cntPage = (int) ceil($count / $limit);

        return [
            'items'   => $items,
            'cntPage' => $cntPage
        ];
    }

    public function countAll()
    {
        static::$statement = $this->connection
            ->prepare('SELECT COUNT(*) AS count FROM '.$this->table);

        $this->doExecute();

        return (int) $this->fetchAssociative()["count"];
    }

    public function doGetAll(?array $where = null, ?string $orderBy = null)
    {
        $search = null;

        if ($where) {
            $search = ' WHERE '.$this->getPreparedWhere($where);
        }

        if ($orderBy) {
            $orderBy = 'ORDER BY '.$orderBy;
        }

        static::$statement = $this->connection
            ->prepare('SELECT * FROM '.$this->table.$search['keys'].' '.$orderBy);


        $this->doExecute($search['values']);

        return $this->fetchAllAssociative();
    }

    public function doGetOne(?array $where = null)
    {
        $search = null;

        if ($where) {
            $search = $this->getPreparedWhere($where);
        }

        static::$statement = $this->connection
            ->prepare('SELECT * FROM '.$this->table.' WHERE '.$search['keys']);


        $this->doExecute($search['values']);

        return $this->fetchAssociative();
    }

    private function getPreparedWhere(array $values)
    {
        $keysMask = [];
        $keys     = [];
        foreach ($values as $key => $value) {
            if (empty($value) || (is_array($value) && empty($value['tmp_name']))) {
                continue;
            }

            $keysMask[] = $key.'=:'.$key;
            $keys[$key] = trim($value);
        }

        $strKeysMask  = implode(' AND ', $keysMask);

        return [
            'values' => $keys,
            'keys'   => $strKeysMask
        ];
    }

    public function doInsert(array $values)
    {
        $maskValues = $this->getPreparedMaskValues($values);

        $sql = sprintf(
            'INSERT INTO %tests (%tests) VALUES (%tests)',
            $this->table,
            $maskValues['keys'],
            $maskValues['values']
        );

        static::$statement = $this->connection
            ->prepare($sql);

        $this->doExecute($values);
    }

    public function doUpdate(array $values, int $id)
    {
        $maskValues = $this->getPreparedUpdateValues($values);

        $sql = sprintf(
            'UPDATE %tests SET %tests WHERE id = %tests',
            $this->table,
            $maskValues['keys'],
            $id
        );

        static::$statement = $this->connection
            ->prepare($sql);

        $this->doExecute($maskValues['values']);

        return true;
    }

    public function doDelete(int $id)
    {
        static::$statement = $this->connection
            ->prepare('DELETE FROM '.static::$table.' WHERE id = :id');

        $this->bindValue(':id', $id);
        $this->doExecute();

        return true;
    }

    private function getPreparedUpdateValues(array $values)
    {
        $keysMask = [];
        $keys     = [];
        foreach ($values as $key => $value) {
            if (empty($value) || (is_array($value) && empty($value['tmp_name']))) {
                continue;
            }

            $keysMask[] = $key.'=:'.$key;
            $keys[$key] = trim($value);
        }

        $strKeysMask  = implode(', ', $keysMask);

        return [
            'values' => $keys,
            'keys'   => $strKeysMask
        ];
    }

    private function getPreparedMaskValues(array $values)
    {
        $keys     = array_keys($values);
        $keysMask = false;

        foreach ($keys as $index => $key) {
            $keysMask[] = ':'.$key;
        }

        $strKeys      = implode(', ', $keys);
        $strKeysMask  = implode(', ', $keysMask);

        return [
            'keys'   => $strKeys,
            'values' => $strKeysMask
        ];
    }

    public function doGetById($id)
    {
        static::$statement = $this->connection->prepare(
            'SELECT * FROM '.static::$table. ' WHERE id = :id LIMIT 1'
        );

        $this->bindValue(':id', $id);
        $this->doExecute();

        return $this->fetchAssociative();
    }

    public function doExecute($arr = null)
    {
        if (!$arr) {
            return static::$statement->execute();
        }
        return static::$statement->execute($arr);
    }

    public function fetchAllAssociative()
    {
        return static::$statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchAssociative()
    {
        return static::$statement->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertedId() {
        return $this->connection->lastInsertId();
    }

    public function bindValue($param, $value)
    {
        $type = $this->getPDOType($value);
        static::$statement->bindValue($param, $value, $type);
    }

    public function bindParam($param, &$var)
    {
        $type = $this->getPDOType($var);
        static::$statement->bindParam($param, $var, $type);
    }

    private function getPDOType($value){
        switch ($value) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollBack()
    {
        $this->connection->rollBack();
    }

    public static function closeConnection()
    {
        if (empty(self::$database)) {
            throw new \Exception('Database connection not found!');
        }

        self::$database->connection = null;
        self::$database->statement  = null;
        self::$database             = null;
    }
}