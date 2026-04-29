<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

// Check Session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

// Check Input
if (!isset($_GET['job_id'])) {
    echo json_encode(["status" => "success", "data" => []]); // Return empty list instead of crashing
    exit;
}

$job_id = intval($_GET['job_id']);

$sql = "SELECT a.*, u.name, u.email, u.phone 
        FROM applications a 
        JOIN users u ON a.seeker_id = u.user_id 
        WHERE a.job_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$res = $stmt->get_result();

$apps = [];
while($row = $res->fetch_assoc()){
    $apps[] = $row;
}

echo json_encode(["status" => "success", "data" => $apps]);
?>