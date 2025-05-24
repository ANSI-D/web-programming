<?php

require_once __DIR__ . "/../config.php";

class BaseDao
{
    protected $connection;
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->connection = new PDO("mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . ";port=" . Config::DB_PORT(), Config::DB_USER(), Config::DB_PASS(), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    protected function query($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params = [])
    {
        $results = $this->query($query, $params);
        return reset($results);
    }

    protected function execute($query, $params = [])
    {
        $prepared_statement = $this->connection->prepare($query);
        if ($params) {
            foreach ($params as $key => $param) {
                $prepared_statement->bindValue($key, $param);
            }
        }
        $prepared_statement->execute();
        return $prepared_statement;
    }

    public function transactionalExecute($query, $params = [])
    {
        try {
            // Start a transaction
            $this->connection->beginTransaction();

            $prepared_statement = $this->connection->prepare($query);
            if ($params) {
                foreach ($params as $key => $param) {
                    $prepared_statement->bindValue($key, $param);
                }
            }
            $prepared_statement->execute();

            // Commit the transaction
            $this->connection->commit();

            return $prepared_statement;
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function insert($table, $entity)
    {
        $columns = implode(', ', array_keys($entity));
        $values = ':' . implode(', :', array_keys($entity));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        $stmt = $this->transactionalExecute($query, $entity);
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }
}