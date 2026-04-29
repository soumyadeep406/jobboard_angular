<?php
session_start();
header("Content-Type: application/json");

require "../../config.php";

/* =============================
   AUTH CHECK
============================= */
if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "Login required"
    ]);
    exit;
}

/* =============================
   ROLE CHECK (IMPORTANT 🔥)
============================= */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'job_seeker'){
    echo json_encode([
        "status" => "error",
        "message" => "Only job seekers allowed"
    ]);
    exit;
}

/* =============================
   GET DATA
============================= */
$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data['job_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "Job ID missing"
    ]);
    exit;
}

$job_id = intval($data['job_id']);
$seeker_id = intval($_SESSION['user_id']);

/* =============================
   CHECK EXISTING (TOGGLE)
============================= */
$stmt = $conn->prepare("
    SELECT saved_id 
    FROM saved_jobs 
    WHERE seeker_id = ? AND job_id = ?
");

$stmt->bind_param("ii", $seeker_id, $job_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){

    /* 🔥 UNSAVE */
    $del = $conn->prepare("
        DELETE FROM saved_jobs 
        WHERE seeker_id = ? AND job_id = ?
    ");
    $del->bind_param("ii", $seeker_id, $job_id);
    $del->execute();

    echo json_encode([
        "status" => "success",
        "message" => "Removed from saved",
        "action" => "unsaved"
    ]);

} else {

    /* 🔥 SAVE */
    $ins = $conn->prepare("
        INSERT INTO saved_jobs (seeker_id, job_id)
        VALUES (?, ?)
    ");
    $ins->bind_param("ii", $seeker_id, $job_id);
    $ins->execute();

    echo json_encode([
        "status" => "success",
        "message" => "Saved successfully",
        "action" => "saved"
    ]);
}
?>