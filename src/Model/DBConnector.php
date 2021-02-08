<?php

namespace Lavi\Model;

use Lavi\Config\Config;
use PDO;

class DBConnector
{
    protected static $statement = null;
    protected $connection;
    protected string $table;

    private static ?DBConnector $instance = null;

    public function __constructor()
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

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function doPrepare(string $query)
    {
        static::$statement = $this->connection->prepare($query);
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