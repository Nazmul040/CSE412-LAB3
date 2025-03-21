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

// Get template file
$template = $resume['template'];
$template_file = "templates/{$template}.php";

if (!file_exists($template_file)) {
    $template_file = "templates/default.php";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Preview Resume - Resume Builder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/resume-preview.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="preview-header">
            <h1>Resume Preview</h1>
            <div class="preview-actions">
                <a href="edit_resume.php?id=<?php echo $resume_id; ?>" class="btn btn-edit">Edit Resume</a>
                <a href="download_resume.php?id=<?php echo $resume_id; ?>" class="btn btn-download">Download PDF</a>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
        
        <div class="resume-preview-container">
            <div class="resume-preview">
                <?php include $template_file; ?>
            </div>
        </div>
    </div>
</body>
</html>