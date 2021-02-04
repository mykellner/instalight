<?php

$database = [
    'host' => '127.0.0.1',
    'name' => 'instalight',
    'user' => 'root',
    'password' => 'mysql'
];

function initDatabase($database)
{
    try {
        return new PDO("mysql:host={$database['host']};dbname={$database['name']}", $database['user'], $database['password']);
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}
