<?php

use App\Helpers\RecursiveFilesExplorer;

require 'bootstrap.php';


$xmlFiles = RecursiveFilesExplorer::getAllFiles('/var/www/src/resources/xml');

$books = new SimpleXMLElement(file_get_contents($xmlFiles[0]->getRealPath()));

foreach ($xmlFiles as $xmlFile) {
    // get data from each file
    $books = new SimpleXMLElement(file_get_contents($xmlFile->getRealPath()));

    // iterate through each book
    foreach ($books as $book) {
        // check if data is present
        $authorName = isset($book->author) ? $book->author->__toString() : null;
        $bookName = isset($book->name) ? $book->name->__toString() : null;

        if (!$authorName) {
            continue;
        }

        // check if the author exists
        $author = $db->table('authors')->select()->where('author', '=', $authorName)->get();

        // if not, create a new author
        if (count($author) === 0) {
            $authorCreated = $db->table('authors')->insert(['author' => $authorName]);

            // add book for this author
            $authorId = $db->getLastInsertedId();

            if ($bookName) {
                $db->table('books')->insert(['author_id' => $authorId, 'name' => $bookName]);
            }
        }

        // if the author exists
        if (count($author) && $bookName) {
            // check if the book present in xml is already in the books table linked to this author
            $bookExists = $db->table('books')->select()
            ->where('name', '=', $bookName)
            ->where('author_id', '=', $author[0]['id'])
            ->count();

            // book not found, time to create it
            if (!$bookExists) {
                $db->table('books')->insert(['author_id' => $author[0]['id'], 'name' => $bookName]);
            }

        }
    }
}





