<?php
include('../../config.php');

$data = json_decode(file_get_contents("php://input"), true);

$app_id = $data['app_id'];

$stmt = $conn->prepare("UPDATE applications SET status='shortlisted' WHERE app_id=?");
$stmt->bind_param("i", $app_id);

if($stmt->execute()){
    echo json_encode([
        "status" => "success",
        "message" => "Candidate shortlisted"
    ]);
}else{
    echo json_encode([
        "status" => "error"
    ]);
}

$stmt->close();
$conn->close();
?>
