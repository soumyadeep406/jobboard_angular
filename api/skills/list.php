<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

error_reporting(0);
require "../../config.php";

/* ================= PAGINATION ================= */

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 10;
$offset = ($page - 1) * $limit;

/* ================= FETCH ================= */

$sql = "SELECT * FROM skills 
        ORDER BY skill_name 
        LIMIT $limit OFFSET $offset";

$res = $conn->query($sql);

$data = [];
while($r = $res->fetch_assoc()){
    $data[] = $r;
}

/* ================= COUNT ================= */

$countRes = $conn->query("SELECT COUNT(*) as total FROM skills");
$total = $countRes->fetch_assoc()['total'];

$totalPages = ceil($total / $limit);

/* ================= RESPONSE ================= */

echo json_encode([
    "status" => "success",
    "data" => $data,
    "currentPage" => $page,
    "totalPages" => $totalPages
]);
?>