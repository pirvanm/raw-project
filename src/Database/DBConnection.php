<?php

namespace App\Database;

use PDO;

abstract class DBConnection
{
    private PDO $db;
    private $host;
    private $port;
    private $user;
    private $password;
    private $dbname;

    public function __construct($host, $port, $user, $password, $dbname)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->pdo = new PDO(sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
                $this->host,
                $this->port,
                $this->dbname,
                $this->user,
                $this->password
            ));

        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getPdoInstance() : PDO
    {
        return $this->pdo;
    }
}