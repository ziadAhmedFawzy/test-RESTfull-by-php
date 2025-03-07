<?php

require './config/database_access.php';


if($method  === "GET") {
    if($id && $id !== 0) {
        $query = $connection ->prepare("SELECT username, now FROM user WHERE id = ?");
        $query -> execute([$id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if(!$user) {
            http_response_code(404);
            echo json_encode(["error_message" => "user undefined", "status" => "failed"]);
        }
        else {
            echo json_encode(["data" => $user, "status" => "success"]);
        }
    }
    else {
        $query = $connection->query("SELECT * FROM user");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["data" => $data, "status" => "successfull"]);
    }
}
elseif($method === "POST") {
    $dataInsert = file_get_contents("php://input");
    $dataJson = json_decode($dataInsert, true);
    if($data) {
        $cheak = $connection->prepare("SELECT count(*) AS total_users FROM user WHERE username = ?");
        $cheak->execute([$dataJson["username"]]);
        $getCheckData = $cheak->fetch(PDO::FETCH_ASSOC);
        if(!$getCheckData["total_users"]) {
            $query = $connection->prepare("INSERT INTO `user`(`username`, `pass`) VALUES (?,?)");
            $query->execute([$dataJson["username"], $dataJson["password"]]);
            echo json_encode(["status" => "success", "message" => "insert success!"]);
        }
        else {
            http_response_code(400);
            echo json_encode(["status" => "failed", "message" => "username is not unique"]);
        }
    }
    else {
        echo json_encode(["status" => "failed", "message" => "failed process"]);
    }
}
elseif($method === "PUT") {
    $Datarequest = file_get_contents("php://input");
    $dataJson = json_decode($Datarequest, true);
    $check2 = $connection->prepare("SELECT * FROM user WHERE id = ?");
    $check2->execute([$dataJson["id"]]);
    $data = $check2->fetch(PDO::FETCH_ASSOC);
    if(!$data) {
        echo json_encode(["error_message" => "invalid id"]);
    }
    else {
        $cheak = $connection->prepare("SELECT count(*) AS total_users FROM user WHERE username = ?");
        $cheak->execute([$dataJson["username"]]);
        $getCheckData = $cheak->fetch(PDO::FETCH_ASSOC);
        if(!$getCheckData["total_users"]) {
            $query = $connection->prepare("UPDATE user SET username = ? WHERE id = ?");
            $query->execute([$dataJson["username"], $dataJson["id"]]);
            echo json_encode(["status" => "it is update success"]);
        }
        else {
            http_response_code(400);
            echo json_encode(["status" => "failed", "message" => "username is not unique"]);
        }
    }
}
elseif($method === "DELETE") {
    $data = file_get_contents("php://input");
    $dataJson = json_decode($data,true);
    $query = $connection->prepare("SELECT * FROM user WHERE id = ?");
    $query->execute([$dataJson["id"]]);
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if(!$data) {
        echo json_encode(["error_message" => "invalid id"]);
    }
    else {
        $query = $connection->prepare("DELETE FROM user WHERE id = ?");
        $query->execute([$dataJson["id"]]);
        echo json_encode(["status" => "success"]);

    }
}