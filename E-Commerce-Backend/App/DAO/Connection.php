<?php

namespace App\DAO;

abstract class Connection
{
    protected \PDO $pdo;

    public function __construct()
    {
        $host = getenv("DEVUTOPIA_SQLSERVER_HOST");
        $dbname = getenv("DEVUTOPIA_SQLSERVER_DBNAME");
        $user = getenv("DEVUTOPIA_SQLSERVER_USER");
        $password = getenv("DEVUTOPIA_SQLSERVER_PASSWORD");

        $dsn = "sqlsrv:Server={$host};Database={$dbname}";

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION,
        );
    }

}