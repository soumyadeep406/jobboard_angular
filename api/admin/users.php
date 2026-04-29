<?php

session_start();
require "../../config.php";

/* =========================
   FILTER CONDITION
========================= */

$where = "WHERE role='job_seeker'";

if(isset($_GET['from']) && isset($_GET['to'])){

$from = $_GET['from'];
$to = $_GET['to'];

$where .= " AND DATE(created_at) BETWEEN '$from' AND '$to'";

}

/* =========================
   DOWNLOAD CSV
========================= */

if(isset($_GET['download'])){

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="jobseekers.csv"');

$output = fopen("php://output","w");

fputcsv($output,['ID','Name','Email','Role']);

$result = $conn->query("
SELECT user_id,name,email,role
FROM users
$where
ORDER BY user_id DESC
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

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

/* Get total jobseekers */

$totalResult = $conn->query("
SELECT COUNT(*) as total
FROM users
$where
");

$totalRow = $totalResult->fetch_assoc();
$totalUsers = $totalRow['total'];
$totalPages = ceil($totalUsers / $limit);

/* Get paginated jobseekers */

$query = "
SELECT user_id,name,email,role,status
FROM users
$where
ORDER BY user_id DESC
LIMIT $limit OFFSET $offset
";

$result = $conn->query($query);

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $users,
    "totalPages" => $totalPages,
    "currentPage" => $page
]);