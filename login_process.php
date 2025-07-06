<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Invalid request method');
}

// Get form data
$email = sanitize_input($_POST['email']);
$password = $_POST['password'];

// Validation
if (empty($email) || empty($password)) {
    json_response(false, 'Email and password are required');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(false, 'Invalid email format');
}

try {
    // Find user by email
    $stmt = $pdo->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        json_response(false, 'Invalid email or password');
    }
    
    // Verify password
    if (!verify_password($password, $user['password'])) {
        json_response(false, 'Invali