<?php

$HOST = "localhost";
$USER = "root";
$PASS = "";
$DB_NAME = "test2";

try {
    $connection = new PDO("mysql: host=$HOST; dbname=$DB_NAME", $USER, $PASS);
    $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "error in connecion " . $e->getMessage();
}