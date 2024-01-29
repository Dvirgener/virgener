<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database
{

    private PDO $connection;
    private PDOStatement $stmt;

    public function __construct(string $driver, array $config, string $username, string $password)
    {
        $config = http_build_query(data: $config, arg_separator: ';');
        $dsn = "{$driver}:{$config}";

        $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }

    public function query(string $query, array $params = []): Database
    {
        $this->stmt = $this->connection->prepare($query);

        $this->stmt->execute($params);

        return $this;
    }

    public function tableId(int $id)
    {
        $this->connection->lastInsertId();
    }

    public function count()
    {
        return $this->stmt->fetchColumn();
    }
    public function countRow()
    {
        return $this->stmt->fetchAll();
    }

    public function find()
    {
        return $this->stmt->fetch();
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    }

    public function findAll()
    {
        return $this->stmt->fetchAll();
    }
}
