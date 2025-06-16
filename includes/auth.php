<?php
require_once '../config/database.php';

if(isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['login'])) {
        // Login process
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: ../index.php");
            exit;
        } else {
            header("Location: ../pages/login.php?error=invalid_credentials");
            exit;
        }
    } elseif(isset($_POST['register'])) {
        // Registration process
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password]);
            
            header("Location: ../pages/login.php?registration=success");
            exit;
        } catch(PDOException $e) {
            if($e->errorInfo[1] === 1062) {
                // Duplicate entry (username or email already exists)
                header("Location: ../pages/register.php?error=duplicate");
                exit;
            } else {
                header("Location: ../pages/register.php?error=unknown");
                exit;
            }
        }
    }
}
?>