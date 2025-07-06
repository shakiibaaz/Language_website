<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Invalid request method');
}

// Get form data
$full_name = sanitize_input($_POST['full_name']);
$email = sanitize_input($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validation
if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
    json_response(false, 'All fields are required');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(false, 'Invalid email format');
}

if (strlen($password) < 6) {
    json_response(false, 'Password must be at least 6 characters long');
}

if ($password !== $confirm_password) {
    json_response(false, 'Passwords do not match');
}

try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        json_response(false, 'Email already exists');
    }
    
    // Hash password
    $hashed_password = hash_password($password);
    
    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role, created_at) VALUES (?, ?, ?, 'user', NOW())");
    $stmt->execute([$full_name, $email, $hashed_password]);
    
    json_response(true, 'Registration successful');
    
} catch (PDOException $e) {
    json_response(false, 'Database error: ' . $e->getMessage());
}
?>