<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is null
if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

$name = $data['company_name'] ?? '';
$website = $data['website'] ?? '';

// Check if profile exists
$check = $conn->query("SELECT * FROM company_profile WHERE recruiter_id=$user_id");

if ($check && $check->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE company_profile SET company_name=?, website=? WHERE recruiter_id=?");
    $stmt->bind_param("ssi", $name, $website, $user_id);
} else {
    $stmt = $conn->prepare("INSERT INTO company_profile (recruiter_id, company_name, website) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $name, $website);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Company profile saved"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}
?>