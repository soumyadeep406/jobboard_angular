<?php
include("../../config.php");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'];

$result = mysqli_query($conn, "SELECT resume FROM users WHERE id='$user_id'");
$row = mysqli_fetch_assoc($result);

if($row['resume']){
    $file_path = "../../" . $row['resume'];
    if(file_exists($file_path)){
        unlink($file_path);
    }

    mysqli_query($conn, "UPDATE users SET resume=NULL WHERE id='$user_id'");
}

echo json_encode(["status"=>"success","message"=>"Resume removed"]);
?>