<?php

class Database {

    public static $connection;

    public static function setUpConnection() {
        if (!isset(Database::$connection)) {
            // Load local environment variables from .env if present
            $envFile = __DIR__ . '/.env';
            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strpos($line, '#') === 0) {
                        continue;
                    }
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $key = trim($parts[0]);
                        $val = trim($parts[1]);
                        if (getenv($key) === false) {
                            putenv("{$key}={$val}");
                            $_ENV[$key] = $val;
                        }
                    }
                }
            }

            $host = getenv('DB_HOST') ?: "localhost";
            $user = getenv('DB_USER') ?: "root";
            $pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : "";
            $name = getenv('DB_NAME') ?: "lion_cinema_db";
            $port = getenv('DB_PORT') ?: "3306";

            Database::$connection = new mysqli($host, $user, $pass, $name, $port);
        }
    }

    public static function iud($q) {
        Database::setUpConnection();
        Database::$connection->query($q);
    }

    public static function search($q) {
        Database::setUpConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }

}

?>