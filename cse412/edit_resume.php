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

// Get resume data
$sql = "SELECT * FROM resumes WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $resume_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit();
}

$resume = $result->fetch_assoc();

// Get resume sections data
$sql = "SELECT * FROM resume_data WHERE resume_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resume_id);
$stmt->execute();
$sections_result = $stmt->get_result();
$resume_data = [];

while ($row = $sections_result->fetch_assoc()) {
    $resume_data[$row['section']] = json_decode($row['data'], true);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section = $_POST['section'];
    $data = json_encode($_POST['data']);
    
    // Check if section already exists
    $sql = "SELECT id FROM resume_data WHERE resume_id = ? AND section = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $resume_id, $section);
    $stmt->execute();
    $check_result = $stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // Update existing section
        $sql = "UPDATE resume_data SET data = ? WHERE resume_id = ? AND section = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $data, $resume_id, $section);
    } else {
        // Insert new section
        $sql = "INSERT INTO resume_data (resume_id, section, data) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $resume_id, $section, $data);
    }
    
    if ($stmt->execute()) {
        // Update completion percentage
        updateCompletionPercentage($conn, $resume_id);
        
        // Return success response for AJAX
        if (isset($_POST['ajax'])) {
            echo json_encode(['success' => true]);
            exit();
        }
        
        // Redirect to the same page to show updated data
        header("Location: edit_resume.php?id=$resume_id&section=$section&saved=1");
        exit();
    }
}

// Function to update completion percentage
function updateCompletionPercentage($conn, $resume_id) {
    $sql = "SELECT COUNT(*) as filled_sections FROM resume_data WHERE resume_id = ? AND JSON_LENGTH(data) > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $resume_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $filled = $result->fetch_assoc()['filled_sections'];
    
    // Total number of sections
    $total_sections = 6; // Personal, Education, Experience, Skills, Projects, Additional
    
    $percentage = min(100, round(($filled / $total_sections) * 100));
    
    $sql = "UPDATE resumes SET completion_percentage = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $percentage, $resume_id);
    $stmt->execute();
}

// Get current section
$current_section = isset($_GET['section']) ? $_GET['section'] : 'personal';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Resume - Resume Builder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit-resume.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="resume-edit-container">
            <div class="resume-sidebar">
                <div class="resume-info">
                    <h2><?php echo htmlspecialchars($resume['title']); ?></h2>
                    <div class="completion-bar">
                        <div class="completion-progress" style="width: <?php echo $resume['completion_percentage']; ?>%"></div>
                    </div>
                    <p class="completion-text"><?php echo $resume['completion_percentage']; ?>% complete</p>
                </div>
                
                <ul class="section-nav">
                    <li class="<?php echo $current_section == 'personal' ? 'active' : ''; ?>">
                        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=personal">Personal Information</a>
                    </li>
                    <li class="<?php echo $current_section == 'education' ? 'active' : ''; ?>">
                        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=education">Education</a>
                    </li>
                    <li class="<?php echo $current_section == 'experience' ? 'active' : ''; ?>">
                        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=experience">Work Experience</a>
                    </li>
                    <li class="<?php echo $current_section == 'skills' ? 'active' : ''; ?>">
                        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=skills">Skills</a>
                    </li>
                    <li class="<?php echo $current_section == 'projects' ? 'active' : ''; ?>">
                        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=projects">Projects</a>
                    </li>
                    <li class="<?php echo $current_section == 'additional' ? 'active' : ''; ?>">
                        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=additional">Additional Information</a>
                    </li>
                </ul>
                
                <div class="sidebar-actions">
                    <a href="view_resume.php?id=<?php echo $resume_id; ?>" class="btn btn-preview">Preview Resume</a>
                    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
            
            <div class="resume-form-container">
                <?php if (isset($_GET['saved'])): ?>
                <div class="alert alert-success">
                    Your changes have been saved successfully!
                </div>
                <?php endif; ?>
                
                <?php include "sections/{$current_section}.php"; ?>
            </div>
        </div>
    </div>
    
    <script src="js/resume-editor.