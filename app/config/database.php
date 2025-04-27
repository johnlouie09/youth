<?php
/*
|-----------------------------------------------------------------------
| Online Database Configuration
|-----------------------------------------------------------------------
| Enter the configuration for your MySQL Online Database
|
|    host    ->  localhost
|    user    ->  u893457880_istambay
|    pass    ->  1stambaySaKanto
|    dbname  ->  u893457880_youth
|
*/

$config = [
    'host'   => 'localhost',
    'user'   => 'root',
    'pass'   => '',
    'dbname' => 'youth'
];

$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

if($conn->connect_error) {
    die(json_encode([
        'error' => $conn->connect_error
    ]));
}
