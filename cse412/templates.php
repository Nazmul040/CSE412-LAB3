<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get all templates
$sql = "SELECT * FROM templates";
$result = $conn->query($sql);
$templates = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Templates - Resume Builder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/templates.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Resume Templates</h1>
        <p>Choose from our professionally designed templates to create your perfect resume.</p>
        
        <div class="templates-grid">
            <?php foreach ($templates as $template): ?>
            <div class="template-card">
                <img src="images/templates/<?php echo $template['thumbnail']; ?>" alt="<?php echo $template['name']; ?>">
                <div class="template-info">
                    <h3><?php echo $template['name']; ?></h3>
                    <p><?php echo $template['description']; ?></p>
                    <a href="create_resume.php?template=<?php echo $template['id']; ?>" class="btn btn-primary">Use Template</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>