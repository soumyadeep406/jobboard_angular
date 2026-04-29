<?php
header("Content-Type: application/json");
require "../../config.php";

// Fetch all users (Seekers, Recruiters, and Admin)
$sql = "SELECT user_id, name, email, role, status, phone FROM users ORDER BY user_id DESC";

$result = $conn->query($sql);

$users = [];
if ($result) {
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
}

// Return data in the format AngularJS expects: { status: "success", data: [...] }
echo json_encode([
    "status" => "success",
    "data" => $users
]);
?>