<?php
session_start();
header("Content-Type: application/json");
require "../../config.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "success"=>false,
        "message"=>"Unauthorized"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$job_id = intval($data['job_id']);
$seeker_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    DELETE FROM saved_jobs
    WHERE seeker_id=? AND job_id=?
");

$stmt->bind_param("ii",$seeker_id,$job_id);

if($stmt->execute()){
    echo json_encode(["success"=>true]);
}else{
    echo json_encode(["success"=>false]);
}
?>