<?php
header("Content-Type: application/json");
require "../../config.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
$stmt->bind_param("i",$data['id']);
$stmt->execute();

echo json_encode(["message"=>"Deleted"]);
