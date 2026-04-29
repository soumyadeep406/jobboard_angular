<?php
session_start();
header("Content-Type: application/json");
// 1. Suppress HTML warnings so they don't break Angular
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

// 2. Read JSON Input
$data = json_decode(file_get_contents("php://input"), true);

// 3. Check if email/password were actually sent
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status"=>"error", "message"=>"Missing email or password"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// 4. Check User in Database
$stmt = $conn->prepare("SELECT user_id, password, role, status FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows == 1){
    $u = $res->fetch_assoc();

    // Verify Password
    if(!password_verify($password, $u['password'])){
        echo json_encode(["status"=>"error", "message"=>"Wrong password"]);
        exit;
    }

    // Verify Status
    if($u['status'] !== 'approved'){
        echo json_encode(["status"=>"error", "message"=>"Account pending approval"]);
        exit;
    }

    // Login Success
    $_SESSION['user_id'] = $u['user_id'];
    $_SESSION['role'] = $u['role'];

    echo json_encode([
        "status"=>"success",
        "role"=>$u['role'],
        "user_id"=>$u['user_id']
    ]);

} else {
    echo json_encode(["status"=>"error", "message"=>"User not found"]);
}
?>