<?php
require "../../config.php";

if(!isset($_GET['type'])){
    echo "Invalid request";
    exit;
}

$type = $_GET['type'];

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$type.".csv");

$output = fopen("php://output", "w");

if($type == "jobs"){
    $result = $conn->query("SELECT job_id,recruiter_id,title FROM job_listings");
}
elseif($type == "companies"){
    $result = $conn->query("SELECT user_id,name,email FROM users WHERE role='recruiter'");
}
elseif($type == "users"){
    $result = $conn->query("SELECT user_id,name,email FROM users WHERE role='job_seeker'");
}
else{
    echo "Invalid type";
    exit;
}

$first = true;

while($row = $result->fetch_assoc()){
    if($first){
        fputcsv($output, array_keys($row));
        $first = false;
    }
    fputcsv($output, $row);
}

fclose($output);