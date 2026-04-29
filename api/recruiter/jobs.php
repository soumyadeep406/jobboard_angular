<?php
session_start();
header("Content-Type: application/json");

// Hide HTML errors to prevent Angular crashes
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

// Check if User ID exists in session
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired. Please login again."
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

/*
    UPGRADED QUERY:
    - Gets all jobs
    - Counts how many applications per job
*/
$stmt = $conn->prepare("
    SELECT 
        j.*,
        COUNT(a.app_id) AS applicant_count
    FROM job_listings j
    LEFT JOIN applications a 
        ON j.job_id = a.job_id
    WHERE j.recruiter_id = ?
    GROUP BY j.job_id
    ORDER BY j.posted_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$jobs = [];

while($row = $res->fetch_assoc()){
    $jobs[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $jobs
]);
?>
