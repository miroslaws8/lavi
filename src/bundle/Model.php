<?php

namespace bundle;

use PDO;

class Model
{
    private $connection = null;
    private $statement  = null;
    private static $database = null;

    protected static $table = false;

    public function __construct()
    {
        try {
            if ($this->connection === null) {
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
            }
        } catch (\PDOException $exception) {
            echo 'Fill in the database access and roll the dump in the /dump folder!';
            exit;
        }
    }

    public static function getConnection()
    {
        if (static::$database === null) {
            static::$database = new self();
        }

        return static::$database;
    }

    public function prepare(string $query)
    {
        $this->statement = $this->connection->prepare($query);
    }

    public function countRows()
    {
        return $this->statement->rowCount();
    }

    public function countAll()
    {
        $this->statement = $this->connection->prepare(
            'SELECT COUNT(*) AS count FROM '.static::$table
        );

        $this->execute();

        return (int) $this->fetchAssociative()["count"];
    }

    public function getAll(string $orderBy = null)
    {
        if ($orderBy) {
            $orderBy = 'ORDER BY '.$orderBy;
        }

        $this->statement = $this->connection
            ->prepare('SELECT * FROM '.static::$table.' '.$orderBy);

        $this->execute();

        return $this->fetchAllAssociative();
    }

    public function insert(array $values)
    {
        $maskValues = $this->getPreparedMaskValues($values);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            static::$table,
            $maskValues['keys'],
            $maskValues['values']
        );

        $this->statement = $this->connection
            ->prepare($sql);

        $this->execute($values);
    }

    public function update(array $values, int $id)
    {
        $maskValues = $this->getPreparedUpdateValues($values);

        $sql = sprintf(
            'UPDATE %s SET %s WHERE id = %s',
            static::$table,
            $maskValues['keys'],
            $id
        );

        $this->statement = $this->connection
            ->prepare($sql);

        $this->execute($maskValues['values']);

        return true;
    }

    public function delete(int $id)
    {
        $this->statement = $this->connection
            ->prepare('DELETE FROM '.static::$table.' WHERE id = :id');

        $this->bindValue(':id', $id);
        $this->execute();

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

    public function getById($id)
    {
        $this->statement = $this->connection->prepare(
            'SELECT * FROM '.static::$table. ' WHERE id = :id LIMIT 1'
        );

        $this->bindValue(':id', $id);
        $this->execute();

        return $this->fetchAssociative();
    }

    public function execute($arr = null)
    {
        if ($arr !== null) {
            return $this->statement->execute($arr);
        }

        return $this->statement->execute();
    }

    public function fetchColumn()
    {
        return $this->statement->fetchAll(\PDO::FETCH_COLUMN, 0);
    }

    public function fetchAllAssociative()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchAssociative()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertedId() {
        return $this->connection->lastInsertId();
    }

    public function bindValue($param, $value)
    {
        $type = $this->getPDOType($value);
        $this->statement->bindValue($param, $value, $type);
    }

    public function bindParam($param, &$var)
    {
        $type = $this->getPDOType($var);
        $this->statement->bindParam($param, $var, $type);
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
        if(isset(self::$database)) {
            self::$database->connection = null;
            self::$database->statement  = null;
            self::$database             = null;
        }
    }
}