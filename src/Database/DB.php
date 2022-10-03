<?php

namespace App\Database;


use PDO;
use PDOStatement;

class DB
{
    private string $table = '';
    private string $query = '';
    private string $whereCondition = '';
    private array $params = [];

    private DBConnection $dbConnection;
    private PDO $pdo;

    public function __construct(DBConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        $this->pdo = $this->dbConnection->getPdoInstance();
    }

    public function table(string $table) : DB
    {
        $this->reset();

        $this->table = $table;

        return $this;
    }

    protected function reset()
    {
        $this->table = '';
        $this->query = '';
        $this->whereCondition = '';
        $this->params = [];
    }

    public function select(string ...$columnsList) : DB
    {
        $this->query = "SELECT ";

        if (count($columnsList) === 0) {
            $this->query .= "*";
        }

        if (count($columnsList) === 1) {
            $this->query .= $columnsList[0];
        }

        if (count($columnsList) > 1) {
            $columnsListString = implode(",", $columnsList);

            $this->query .= $columnsListString;
        }

        $this->query .= " FROM {$this->table}";

        return $this;
    }

    public function insert(array $data) : int
    {
        $this->query = "INSERT INTO {$this->table} (";

        $columns = array_keys($data);
        $columnsList = implode(',', $columns);

        $this->query .= $columnsList . ') ';

        $this->query .= "VALUES (";

        for ($i = 0; $i < count($data); $i++) {
            $this->query .= '?,';
        }

        $this->query = substr_replace($this->query, "", -1);
        $this->query .= ')';

        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute(array_values($data));

        return $stmt->rowCount();

    }

    public function update(array $data) : int
    {
        $this->query = "UPDATE {$this->table} SET ";

        $tmp = '';
        foreach ($data as $field => $value) {
            $tmp .= $field . '=' . '?,';
            $this->params[] = $value;
        }

        $tmp = substr_replace($tmp, "", -1);

        $this->query .= $tmp . ' ';

        $this->params = array_reverse($this->params);

        return $this->execute()->rowCount();
    }

    public function where($field, $operator, $value) : DB
    {
        if ($this->whereCondition) {
            $this->whereCondition .= " AND {$field} {$operator} ?";
        } else {
            $this->whereCondition = " WHERE {$field} {$operator} ?";
        }

        $this->params[] = $value;

        return $this;
    }

    public function raw(string $query, array $data = []) : int|array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($data));

        if (strpos($query, "SELECT") !== false) {      
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $stmt->rowCount();
    }

    private function execute() : PDOStatement
    {
        $this->query .= $this->whereCondition;

        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute(array_values($this->params));

        return $stmt;
    }

    public function count() : int
    {
        $stmt = $this->execute();

        return $stmt->rowCount();
    }

    public function getLastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

    public function get() : array
    {
        $stmt = $this->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}