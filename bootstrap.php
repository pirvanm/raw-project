<?php

require 'vendor/autoload.php';

use App\Database\DB;
use App\Database\PGSQLConnection;
use App\Database\Table\PGSQLCreateTable;
use App\Helpers\RecursiveFilesExplorer;

$dbConn = new PGSQLConnection("db", 5432, "root", "password", "library");

$table = new PGSQLCreateTable($dbConn);
$table->createTables();

$db = new DB($dbConn);