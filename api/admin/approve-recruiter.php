<?php
session_start();
header('Content-Type: application/json');

// 1. Hide HTML errors so they don't break the App
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

// 2. Check Admin Role
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo json_encode(["status"=>"error", "message"=>"Unauthorized"]);
    exit;
}

// 3. READ JSON DATA (The Fix)
$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id'] ?? 0); // Use Null Coalescing operator to avoid "Undefined index" warning

if($id > 0) {
    $stmt = $conn->prepare("UPDATE users SET status='approved' WHERE user_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Invalid ID"]);
}
?>