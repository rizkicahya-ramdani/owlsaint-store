<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Get product details
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? FOR UPDATE");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$product || $product['status'] !== 'tersedia') {
            throw new Exception("Product not available");
        }
        
        // Create transaction
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, product_id, total_price, status) VALUES (?, ?, ?, 'completed')");
        $stmt->execute([$user_id, $product_id, $product['price']]);
        
        // Update product status
        $stmt = $pdo->prepare("UPDATE products SET status = 'terjual' WHERE id = ?");
        $stmt->execute([$product_id]);
        
        // Commit transaction
        $pdo->commit();
        
        $_SESSION['message'] = "Purchase successful! Account details have been sent to your email.";
        header("Location: ../pages/profile.php");
        exit;
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Purchase failed: " . $e->getMessage();
        header("Location: ../pages/product-detail.php?id=$product_id");
        exit;
    }
} else {
    header("Location: ../pages/products.php");
    exit;
}
?>