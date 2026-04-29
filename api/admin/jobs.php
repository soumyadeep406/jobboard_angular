<?php

session_start();
require "../../config.php";

/* =========================
   DOWNLOAD CSV
========================= */

if(isset($_GET['download'])){

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="jobs.csv"');

$output = fopen("php://output","w");

fputcsv($output,['Job ID','Title','Location','Status','Recruiter']);

$result = $conn->query("
SELECT 
    j.job_id,
    j.title,
    j.location,
    j.status,
    u.name AS recruiter_name
FROM job_listings j
JOIN users u ON j.recruiter_id = u.user_id
ORDER BY j.job_id DESC
");

while($row = $result->fetch_assoc()){
    fputcsv($output,$row);
}

fclose($output);
exit;

}

/* =========================
   NORMAL API (VIEW TABLE)
========================= */

header("Content-Type: application/json");

/* Check Admin */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

/* Pagination */

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

/* Total jobs */

$totalResult = $conn->query("SELECT COUNT(*) as total FROM job_listings");
$totalRow = $totalResult->fetch_assoc();
$totalJobs = $totalRow['total'];
$totalPages = ceil($totalJobs / $limit);

/* Fetch jobs */

$stmt = $conn->prepare("
SELECT 
    j.job_id,
    j.title,
    j.location,
    j.status,
    u.name AS recruiter_name
FROM job_listings j
JOIN users u ON j.recruiter_id = u.user_id
ORDER BY j.job_id DESC
LIMIT ? OFFSET ?
");

$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();

$result = $stmt->get_result();

$jobs = [];

while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $jobs,
    "totalPages" => $totalPages,
    "currentPage" => $page
]);