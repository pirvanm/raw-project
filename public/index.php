<?php

require '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q']) && !empty($_GET['q'])) {
    $results = $db->raw(
        "SELECT authors.author, books.name FROM authors
        LEFT JOIN books
        ON authors.id = books.author_id
        WHERE LOWER(authors.author) LIKE ?
        ",
        [
            'author' => '%'. strtolower($_GET['q']) .'%'
        ]
    );

    array_walk($results, function (&$row) {
        if (is_null($row['name'])) {
            $row['name'] = "<none> no book found";
        }
    });

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($results);
} else {
    require '../src/resources/views/index.view.php';
}






