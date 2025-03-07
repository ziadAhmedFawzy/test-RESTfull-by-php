<?php

function CheckId($id) {
    global $connection;
    $query = $connection->prepare("SELECT * FROM user WHERE id = ?");
    $query->execute([$id]);
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if(!$data) {
        return "false";
    }
    else {
        return "true";
    }
}