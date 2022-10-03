<?php

namespace App\Database\Table;

use PDO;
use App\Database\DBConnection;
use App\Database\PGSQLConnection;

class PGSQLCreateTable
{
    protected PGSQLConnection $dbConn;
    protected PDO $pdo;

    public function __construct(DBConnection $dbConn)
    {
        $this->dbConn = $dbConn;
        $this->pdo = $dbConn->getPdoInstance();
    }

    public function createTables() : void
    {
        if ($this->hasTables() === 0) {
            $sqlTables = [
                'CREATE TABLE IF NOT EXISTS authors (
                    id serial PRIMARY KEY,
                    author character varying(255) NOT NULL UNIQUE
                 );',
                 'CREATE TABLE IF NOT EXISTS books (
                    id serial PRIMARY KEY,
                    author_id serial NOT NULL,
                    name character varying(255) NOT NULL,
                    FOREIGN KEY (author_id) REFERENCES authors(id)
                 );',
            ];

            foreach ($sqlTables as $sqlTable) {
                $this->pdo->exec($sqlTable);
            }
        }
    }

    protected function dropTables() : void
    {
        // if ever needed
    }

    protected function hasTables() : int
    {
        $stmt = $this->pdo->query(
            "SELECT table_name FROM information_schema.tables
             WHERE table_schema = 'public'
                AND table_type = 'BASE TABLE'
            ");

        return $stmt->rowCount();
    }
}