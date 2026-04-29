<?php
session_start();
header('Content-Type: application/json');

// 1. Use the central config file (This fixes the database password error)
require "../../config.php";

// 2. Check if user is logged in
// Check login
if(!isset($_SESSION['user_id'])){
    echo json_encode(["status"=>"error", "message"=>"Login required"]);
    exit;
}

// 🔥 ADD ROLE CHECK
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'job_seeker'){
    echo json_encode(["status"=>"error", "message"=>"Only job seekers allowed"]);
    exit;
}

// 3. Get JSON Input
$data = json_decode(file_get_contents("php://input"), true);
$job_id = intval($data['job_id']);
$user_id = $_SESSION['user_id'];

// 4. Validate Input
if($job_id <= 0) {
    echo json_encode(["status"=>"error", "message"=>"Invalid Job ID"]);
    exit;
}

// 5. Check if already applied
$check = $conn->query("SELECT app_id FROM applications WHERE job_id=$job_id AND seeker_id=$user_id");

if($check->num_rows > 0){
    echo json_encode(["status"=>"error", "message"=>"Already applied"]);
    exit;
}

// 6. Insert Application
$stmt = $conn->prepare("INSERT INTO applications(job_id, seeker_id, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("ii", $job_id, $user_id);

if($stmt->execute()){
    echo json_encode(["status"=>"success", "message"=>"Applied successfully"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Database Error"]);
}
?>