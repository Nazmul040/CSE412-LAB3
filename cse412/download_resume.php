<?php
session_start();
require_once 'config/db.php';
require_once 'vendor/autoload.php'; // Require the TCPDF library

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

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Resume Builder');
$pdf->SetAuthor($resume_data['personal']['fullname'] ?? 'User');
$pdf->SetTitle($resume['title']);
$pdf->SetSubject('Resume');

// Remove header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(15, 15, 15);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

// Add a page
$pdf->AddPage();

// Get the HTML content from the template
ob_start();
include 'templates/pdf_' . $resume['template'] . '.php';
$html = ob_get_clean();

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for download
$filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $resume['title']) . '_Resume.pdf';
$pdf->Output($filename, 'D');
exit;
?>