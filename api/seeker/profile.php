<?php
session_start();
header("Content-Type: application/json");
require "../../config.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode(["status"=>"error"]);
    exit;
}

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $res = $conn->query(
        "SELECT user_id,name,email,phone,resume 
         FROM users 
         WHERE user_id=$user_id"
    );

    echo json_encode([
        "status"=>"success",
        "data"=>$res->fetch_assoc()
    ]);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare(
        "UPDATE users SET name=?, phone=? WHERE user_id=?"
    );

    $stmt->bind_param("ssi",$data['name'],$data['phone'],$user_id);
    $stmt->execute();

    echo json_encode(["status"=>"success","message"=>"Profile updated"]);
}
?>