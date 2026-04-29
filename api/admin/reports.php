<?php
require "../../config.php";

/* ============================
   DATE FILTER
============================ */
if(isset($_GET['from']) && isset($_GET['to'])){

    $from = $_GET['from'];
    $to = $_GET['to'];

    $users = $conn->query("
        SELECT * FROM users 
        WHERE role='job_seeker' 
        AND DATE(created_at) BETWEEN '$from' AND '$to'
    ");

    $jobs = $conn->query("
        SELECT * FROM job_listings 
        WHERE DATE(created_at) BETWEEN '$from' AND '$to'
    ");

    $companies = $conn->query("
        SELECT * FROM users 
        WHERE role='recruiter' 
        AND DATE(created_at) BETWEEN '$from' AND '$to'
    ");

    echo json_encode([
        "users" => $users->fetch_all(MYSQLI_ASSOC),
        "jobs" => $jobs->fetch_all(MYSQLI_ASSOC),
        "companies" => $companies->fetch_all(MYSQLI_ASSOC)
    ]);

    exit;
}

/* ============================
   TOTALS (FOR PIE CHART)
============================ */

$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='job_seeker'")
->fetch_assoc()['total'];

$totalJobs = $conn->query("SELECT COUNT(*) as total FROM job_listings")
->fetch_assoc()['total'];

$totalCompanies = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='recruiter'")
->fetch_assoc()['total'];

echo json_encode([
    "totalUsers" => $totalUsers,
    "totalJobs" => $totalJobs,
    "totalCompanies" => $totalCompanies
]);