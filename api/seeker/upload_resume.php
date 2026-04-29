<?php
header("Content-Type: application/json");
include("../../config.php");

if(!isset($_POST['user_id'])){
    echo json_encode(["status"=>"error","message"=>"User ID missing"]);
    exit();
}

$user_id = $_POST['user_id'];

if(!isset($_FILES['resume'])){
    echo json_encode(["status"=>"error","message"=>"No file uploaded"]);
    exit();
}

$file_name = $_FILES['resume']['name'];
$file_tmp  = $_FILES['resume']['tmp_name'];
$file_size = $_FILES['resume']['size'];
$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

$allowed = ['pdf','doc','docx'];

if(!in_array($file_ext,$allowed)){
    echo json_encode(["status"=>"error","message"=>"Invalid file type"]);
    exit();
}

if($file_size > 2*1024*1024){
    echo json_encode(["status"=>"error","message"=>"File too large (Max 2MB)"]);
    exit();
}

$new_name = uniqid()."_".basename($file_name);

$upload_dir = __DIR__."/../../uploads/resume/";
$upload_path = $upload_dir.$new_name;


/* -------- Delete old resume if exists -------- */

$res = $conn->query("SELECT resume FROM users WHERE user_id='$user_id'");
$row = $res->fetch_assoc();

if($row && $row['resume']){
    $old_file = __DIR__."/../../".$row['resume'];
    if(file_exists($old_file)){
        unlink($old_file);
    }
}


/* -------- Upload new resume -------- */

if(move_uploaded_file($file_tmp,$upload_path)){

    $db_path = "uploads/resume/".$new_name;

    $stmt = $conn->prepare("UPDATE users SET resume=? WHERE user_id=?");
    $stmt->bind_param("si",$db_path,$user_id);
    $stmt->execute();

    echo json_encode([
        "status"=>"success",
        "path"=>$db_path
    ]);

}else{

    echo json_encode([
        "status"=>"error",
        "message"=>"Upload failed"
    ]);
}
?>