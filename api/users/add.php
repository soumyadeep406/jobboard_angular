<?php
header("Content-Type: application/json");
require "../../config.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$role = $data['role'];

$stmt = $conn->prepare(
"INSERT INTO users(name,email,password,role,status)
VALUES(?,?,?,?, 'approved')"
);
$stmt->bind_param("ssss",$name,$email,$password,$role);

if($stmt->execute()){
    echo json_encode(["message"=>"User added"]);
}else{
    echo json_encode(["message"=>"Email exists"]);
}
