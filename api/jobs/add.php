<?php
session_start();
header('Content-Type: application/json');

// 1. Use the central config file (Fixes the password error)
require "../../config.php";

// 2. Check if user is a Recruiter
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'recruiter'){
    echo json_encode(["status"=>"error", "message"=>"Unauthorized access"]);
    exit;
}

// 3. Receive JSON Input
$data = json_decode(file_get_contents("php://input"), true);

// 4. Extract Variables
$title = $data['title'] ?? '';
$desc = $data['description'] ?? '';
$location = $data['location'] ?? '';
$skills = $data['skills'] ?? []; // Array of skills

// 5. Basic Validation
if(!$title || !$location) {
    echo json_encode(["status"=>"error", "message"=>"Title and Location are required"]);
    exit;
}

// 6. Insert Job Listing
$stmt = $conn->prepare("INSERT INTO job_listings(recruiter_id, title, description, location) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $_SESSION['user_id'], $title, $desc, $location);

if($stmt->execute()){
    $job_id = $conn->insert_id;

    // 7. Insert Skills (Optional loop)
    if (!empty($skills)) {
        foreach($skills as $skillName){
            $skillName = strtolower(trim($skillName));
            if(empty($skillName)) continue;

            // Check if skill exists, if not add it
            $sCheck = $conn->query("SELECT skill_id FROM skills WHERE skill_name='$skillName'");
            if($sCheck->num_rows > 0){
                $skill_id = $sCheck->fetch_assoc()['skill_id'];
            } else {
                $conn->query("INSERT INTO skills(skill_name) VALUES ('$skillName')");
                $skill_id = $conn->insert_id;
            }

            // Link skill to job
            $conn->query("INSERT IGNORE INTO job_skills(job_id, skill_id) VALUES ($job_id, $skill_id)");
        }
    }

    echo json_encode(["status"=>"success", "message"=>"Job posted successfully"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Database Error: " . $conn->error]);
}
?>