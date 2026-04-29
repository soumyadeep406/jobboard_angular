<?php
header("Content-Type: application/json");
require "../../config.php";

// ===== GET PARAMETERS =====
$skill = isset($_GET['skill']) ? trim($_GET['skill']) : '';
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 5; // jobs per page
$offset = ($page - 1) * $limit;

// ===== BUILD BASE QUERY =====
$sql = "FROM job_listings WHERE 1=1";
$params = [];
$types = "";

// Filter by Skill/Title
if (!empty($skill)) {
    $sql .= " AND (title LIKE ? OR description LIKE ?)";
    $searchTerm = "%" . $skill . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "ss";
}

// Filter by Location
if (!empty($location)) {
    $sql .= " AND location LIKE ?";
    $locTerm = "%" . $location . "%";
    $params[] = $locTerm;
    $types .= "s";
}

// ===== GET TOTAL COUNT =====
$countSql = "SELECT COUNT(*) as total " . $sql;
$countStmt = $conn->prepare($countSql);

if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRow = $countResult->fetch_assoc();
$totalJobs = $totalRow['total'];
$totalPages = ceil($totalJobs / $limit);

// ===== GET PAGINATED DATA =====
$dataSql = "SELECT * " . $sql . " ORDER BY posted_at DESC LIMIT ? OFFSET ?";
$dataStmt = $conn->prepare($dataSql);

// Add limit & offset to parameters
$paramsWithLimit = $params;
$typesWithLimit = $types . "ii";
$paramsWithLimit[] = $limit;
$paramsWithLimit[] = $offset;

if (!empty($paramsWithLimit)) {
    $dataStmt->bind_param($typesWithLimit, ...$paramsWithLimit);
}

$dataStmt->execute();
$result = $dataStmt->get_result();

$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

// ===== RETURN JSON =====
echo json_encode([
    "status" => "success",
    "data" => $jobs,
    "totalPages" => $totalPages,
    "currentPage" => $page
]);
?>
