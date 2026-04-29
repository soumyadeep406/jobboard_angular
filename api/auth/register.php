<?php
header("Content-Type: application/json");
require "../../config.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$role = $data['role'] ?? 'job_seeker';

if(!$name || !$email || !$password){
    echo json_encode(["status"=>"error","message"=>"Missing fields"]);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$status = ($role === 'recruiter') ? 'pending' : 'approved';

$stmt = $conn->prepare(
    "INSERT INTO users(name,email,password,role,status)
     VALUES(?,?,?,?,?)"
);
$stmt->bind_param("sssss",$name,$email,$hash,$role,$status);

if($stmt->execute()){
    echo json_encode(["status"=>"success","message"=>"Registered successfully"]);
}else{
    echo json_encode(["status"=>"error","message"=>"Email already exists"]);
}
