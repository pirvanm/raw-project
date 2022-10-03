<?php

namespace App\Helpers;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class RecursiveFilesExplorer
{
    public static function getAllFiles(string $directory = './'): array
    {
        $result = [];

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::SELF_FIRST );
        /** @var $fileInfo SplFileInfo */
        foreach ($iterator as $fileInfo ) {
            if ($fileInfo->isFile()) {
               $result[] = $fileInfo;
            }
        }

        return $result;
    }
}