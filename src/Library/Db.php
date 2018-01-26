<?php

namespace Library;

use \PDO;

class Db
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct($config)
    {
        $this->connect($config);
    }

    public function connect($config)
    {
        $this->connection = new PDO(
            $this->getDsn($config['driver'], $config['host'], $config['database_name']),
            $config['user'], $config['password']);
    }

    public function execute($statement)
    {
        $pdoStatement = $this->connection->prepare($statement['query']);

        $pdoStatement->execute(array_key_exists('bind', $statement) ? $statement['bind'] : null);
    }

    public function query($statement)
    {
        $pdoStatement = $this->connection->prepare($statement['query']);

        $pdoStatement->execute(array_key_exists('bind', $statement) ? $statement['bind'] : null);

        return $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastInsertId()
    {
       return $this->connection->lastInsertId();
    }

    private function getDsn($driver, $host, $dbname)
    {
        $template = '%s:host=%s;dbname=%s';
        return sprintf($template, $driver, $host, $dbname);
    }
}