<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user's resumes
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM resumes WHERE user_id = ? ORDER BY updated_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$resumes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Resume Builder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <a href="create_resume.php" class="btn btn-primary">Create New Resume</a>
        </div>
        
        <div class="dashboard-content">
            <h2>Your Resumes</h2>
            
            <?php if (count($resumes) > 0): ?>
                <div class="resume-grid">
                    <?php foreach ($resumes as $resume): ?>
                        <div class="resume-card">
                            <div class="resume-card-header">
                                <h3><?php echo htmlspecialchars($resume['title']); ?></h3>
                                <span class="template-badge"><?php echo htmlspecialchars($resume['template']); ?></span>
                            </div>
                            <div class="resume-card-body">
                                <p>Last updated: <?php echo date('M d, Y', strtotime($resume['updated_at'])); ?></p>
                                <div class="completion-bar">
                                    <div class="completion-progress" style="width: <?php echo $resume['completion_percentage']; ?>%"></div>
                                </div>
                                <p class="completion-text"><?php echo $resume['completion_percentage']; ?>% complete</p>
                            </div>
                            <div class="resume-card-actions">
                                <a href="edit_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="view_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-view">View</a>
                                <a href="download_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-download">Download</a>
                                <button class="btn btn-delete" onclick="confirmDelete(<?php echo $resume['id']; ?>)">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <img src="images/empty-resume.svg" alt="No resumes">
                    <h3>You haven't created any resumes yet</h3>
                    <p>Get started by creating your first resume!</p>
                    <a href="create_resume.php" class="btn btn-primary">Create Resume</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    function confirmDelete(resumeId) {
        if (confirm("Are you sure you want to delete this resume?")) {
            window.location.href = "delete_resume.php?id=" + resumeId;
        }
    }
    </script>
</body>
</html>