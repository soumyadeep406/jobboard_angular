<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 0);

require "../../config.php";

/* =============================
   AUTH CHECK
============================= */
if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "Login required"
    ]);
    exit();
}

$seeker_id = intval($_SESSION['user_id']);


/* =============================
   PAGINATION
============================= */
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;


/* =============================
   COUNT TOTAL SAVED JOBS
============================= */
$count_sql = "SELECT COUNT(*) as total
              FROM saved_jobs
              WHERE seeker_id = ?";

$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $seeker_id);
$count_stmt->execute();

$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];

$total_pages = ceil($total_rows / $limit);


/* =============================
   FETCH SAVED JOBS
============================= */
$sql = "SELECT 
            j.job_id,
            j.title,
            j.location,
            j.posted_at
        FROM saved_jobs s
        JOIN job_listings j 
            ON s.job_id = j.job_id
        WHERE s.seeker_id = ?
        ORDER BY j.posted_at DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $seeker_id, $limit, $offset);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}


/* =============================
   RESPONSE
============================= */
echo json_encode([
    "status" => "success",
    "data" => $data,
    "currentPage" => $page,
    "totalPages" => $total_pages
]);

?>