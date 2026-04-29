<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo json_encode(["status"=>"error"]);
    exit;
}

// READ JSON DATA
$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id'] ?? 0);

if($id > 0){
    $stmt = $conn->prepare("UPDATE users SET status='blocked' WHERE user_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Invalid ID"]);
}
?>