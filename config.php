<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'enpack');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start session
session_start();

// Security functions
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

function Upload($file,$tmp,$dir,$size,$ex,$width='500',$height='500',$url='',$type='')
{
    $rnd = uniqid();
    $file = str_replace(' ','-',trim($file));
    if($type=='pic') {
        list($w, $h) = @getimagesize($tmp);
    }
    $allowed_filetypes = explode(',',$ex);
    $ext = pathinfo($file);
    if(!in_array(strtolower($ext['extension']),$allowed_filetypes))
    {
        header('location:'.$url.'?op=extension');
        exit;
    }
    if(filesize($tmp) > $size )
    {
        header('location:'.$url.'?op=size');
        exit;
    }
    if($type=='pic') {
        if ($w > $width || $h > $height) {
            header('location:' . $url . '?op=width');
            exit;
        }
    }
    if(move_uploaded_file($tmp,$dir.$rnd.'-'.$file))
        return $rnd.'-'.$file;
    return false;
}

// Response helper
function json_response($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

if(!isset($_SESSION))
    session_start();
?>