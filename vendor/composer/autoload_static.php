<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55b961226c92fc33f7690e4bfc115ec5
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'App\\Database\\DB' => __DIR__ . '/../..' . '/src/Database/DB.php',
        'App\\Database\\DBConnection' => __DIR__ . '/../..' . '/src/Database/DBConnection.php',
        'App\\Database\\MySQLConnection' => __DIR__ . '/../..' . '/src/Database/MySQLConnection.php',
        'App\\Database\\PGSQLConnection' => __DIR__ . '/../..' . '/src/Database/PGSQLConnection.php',
        'App\\Database\\Table\\PGSQLCreateTable' => __DIR__ . '/../..' . '/src/Database/Table/PGSQLCreateTable.php',
        'App\\Helpers\\RecursiveFilesExplorer' => __DIR__ . '/../..' . '/src/Helpers/RecursiveFilesExplorer.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55b961226c92fc33f7690e4bfc115ec5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55b961226c92fc33f7690e4bfc115ec5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit55b961226c92fc33f7690e4bfc115ec5::$classMap;

        }, null, ClassLoader::class);
    }
}