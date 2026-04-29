<?php
session_start();
header("Content-Type: application/json");

require "../../config.php";

// Check if user logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT j.title, a.status
        FROM applications a
        JOIN job_listings j ON a.job_id = j.job_id
        WHERE a.seeker_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
?>