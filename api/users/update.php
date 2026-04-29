<?php
header("Content-Type: application/json");
require "../../config.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare(
"UPDATE users SET name=? WHERE user_id=?"
);
$stmt->bind_param("si",$data['name'],$data['user_id']);
$stmt->execute();

echo json_encode(["message"=>"Updated"]);
