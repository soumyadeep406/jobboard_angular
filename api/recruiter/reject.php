<?php

// Show errors during development (TURN OFF in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
include('../../config.php');

// Read Angular JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Safety check
if(!isset($data['app_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "Application ID missing"
    ]);
    exit;
}

$app_id = $data['app_id'];

// Prepare query (prevents SQL injection)
$stmt = $conn->prepare("UPDATE applications SET status='rejected' WHERE app_id=?");

$stmt->bind_param("i", $app_id);

// Execute
if($stmt->execute()){

    echo json_encode([
        "status" => "success",
        "message" => "Application rejected successfully"
    ]);

}else{

    echo json_encode([
        "status" => "error",
        "message" => "Failed to reject application"
    ]);

}

// Close connection
$stmt->close();
$conn->close();

?>
