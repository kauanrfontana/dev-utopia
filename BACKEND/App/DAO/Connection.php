<?php

namespace App\DAO;

abstract class Connection
{
    protected \PDO $pdo;

    public function __construct()
    {
        $host = getenv('GERENCIADOR_DE_LOJAS_SQLSERVER_HOST');
        $dbname = getenv('GERENCIADOR_DE_LOJAS_SQLSERVER_DBNAME');
        $user = getenv('GERENCIADOR_DE_LOJAS_SQLSERVER_USER');
        $password = getenv('GERENCIADOR_DE_LOJAS_SQLSERVER_PASSWORD');

        $dsn = "sqlsrv:Server={$host};Database={$dbname}";

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION,
        );
    }

}