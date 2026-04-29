<?php
// 1. Set JSON headers first to prevent HTML errors usually
header("Content-Type: application/json");

// 2. Disable error display in output (logs them instead) to keep JSON valid
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

// 3. Receive Input
$data = json_decode(file_get_contents("php://input"), true);

// 4. Validate Input
if (!isset($data['skill_name']) || empty(trim($data['skill_name']))) {
    echo json_encode(["status" => "error", "message" => "Skill name is required"]);
    exit;
}

$name = strtolower(trim($data['skill_name']));

// 5. Insert into Database
$stmt = $conn->prepare("INSERT IGNORE INTO skills(skill_name) VALUES(?)");
$stmt->bind_param("s", $name);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Skill added"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}
?>