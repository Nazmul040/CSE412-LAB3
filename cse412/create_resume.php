<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get available templates
$sql = "SELECT * FROM templates";
$result = $conn->query($sql);
$templates = $result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $template_id = mysqli_real_escape_string($conn, $_POST['template_id']);
    $user_id = $_SESSION['user_id'];
    
    // Get template name
    $sql = "SELECT name FROM templates WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $template_id);
    $stmt->execute();
    $template_result = $stmt->get_result();
    $template = $template_result->fetch_assoc();
    $template_name = $template['name'];
    
    // Create new resume
    $sql = "INSERT INTO resumes (user_id, title, template, template_id, completion_percentage) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $user_id, $title, $template_name, $template_id);
    
    if ($stmt->execute()) {
        $resume_id = $stmt->insert_id;
        header("Location: edit_resume.php?id=$resume_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Resume - Resume Builder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/templates.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Create New Resume</h1>
        
        <form method="POST" action="" class="create-resume-form">
            <div class="form-group">
                <label for="title">Resume Title</label>
                <input type="text" id="title" name="title" required placeholder="e.g. My Professional Resume">
            </div>
            
            <h2>Choose a Template</h2>
            <div class="templates-grid">
                <?php foreach ($templates as $template): ?>
                <div class="template-card">
                    <input type="radio" id="template_<?php echo $template['id']; ?>" name="template_id" value="<?php echo $template['id']; ?>" required>
                    <label for="template_<?php echo $template['id']; ?>">
                        <img src="images/templates/<?php echo $template['thumbnail']; ?>" alt="<?php echo $template['name']; ?>">
                        <div class="template-info">
                            <h3><?php echo $template['name']; ?></h3>
                            <p><?php echo $template['description']; ?></p>
                        </div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Resume</button>
        </form>
    </div>
</body>
</html>