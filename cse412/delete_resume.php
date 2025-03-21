<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if resume ID is provided
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$resume_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Verify that the resume belongs to the user
$sql = "SELECT id FROM resumes WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $resume_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit();
}

// Delete resume data first (foreign key constraint)
$sql = "DELETE FROM resume_data WHERE resume_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resume_id);
$stmt->execute();

// Delete the resume
$sql = "DELETE FROM resumes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resume_id);
$stmt->execute();

// Redirect back to dashboard
header("Location: dashboard.php?deleted=1");
exit();
?>