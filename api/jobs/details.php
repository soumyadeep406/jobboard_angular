<?php
header("Content-Type: application/json");
require "../../config.php";

$id = intval($_GET['id']);

$res = $conn->query(
"SELECT * FROM job_listings WHERE job_id=$id"
);

echo json_encode($res->fetch_assoc());
