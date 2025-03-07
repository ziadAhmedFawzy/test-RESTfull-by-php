<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Header: Content-Type, Authorization");

include './middleware/authToken.php';

$path = explode('/', trim($_SERVER["REQUEST_URI"], '/'));
$method = $_SERVER["REQUEST_METHOD"];
$id = $path[2] ?? "";

if($path[0] === 'api' && !isset($_COOKIE["username"])) {
    // if(!Auth($_COOKIE["username"])) {
        $resource = $path[1] ?? "";
        switch($resource) {
            case "user":
                require './API/user.php';
                break;
            default:
            echo json_encode(["error_message" => "invalid end point"]);
    }
    // }
    // else {
    //     echo json_encode(["error_message" => "access deined"]);
    // }
}