<?php
// Disable on-screen error reporting (prevents breaking JSON)
error_reporting(E_ALL);
ini_set('display_errors', 0);

$conn = new mysqli("localhost", "root", "", "jobboard"); // Use your correct password here

if ($conn->connect_error) {
    // Return JSON error instead of HTML die()
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}
?>