<?php

session_start();
require "../../config.php";

/* =========================
   DOWNLOAD CSV
========================= */

if(isset($_GET['download'])){

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="companies.csv"');

$output = fopen("php://output","w");

fputcsv($output,['ID','Name','Email','Status']);

$result = $conn->query("
SELECT user_id,name,email,status 
FROM users 
WHERE role='recruiter'
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

/* Check Admin */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

/* Pagination */
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

/* Total recruiters */

$totalResult = $conn->query("
SELECT COUNT(*) as total 
FROM users 
WHERE role='recruiter'
");

$totalRow = $totalResult->fetch_assoc();
$totalRecruiters = $totalRow['total'];
$totalPages = ceil($totalRecruiters / $limit);

/* Get recruiters */

$stmt = $conn->prepare("
SELECT user_id,name,email,status
FROM users
WHERE role='recruiter'
ORDER BY user_id DESC
LIMIT ? OFFSET ?
");

$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();

$result = $stmt->get_result();

$recruiters = [];

while ($row = $result->fetch_assoc()) {
    $recruiters[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $recruiters,
    "totalPages" => $totalPages,
    "currentPage" => $page
]);