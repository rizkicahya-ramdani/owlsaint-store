<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Tambah ke cart
if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    
    // Validasi produk
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND status = 'tersedia'");
    $stmt->execute([$product_id]);
    
    if($stmt->rowCount() > 0) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if(!in_array($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product_id;
            $_SESSION['message'] = "Product added to cart!";
        } else {
            $_SESSION['message'] = "Product already in cart!";
        }
    }
    
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}

// Proses checkout
if(isset($_POST['checkout'])) {
    if(empty($_SESSION['cart'])) {
        $_SESSION['error'] = "Your cart is empty!";
        header("Location: ../pages/cart.php");
        exit;
    }
    
    try {
        $pdo->beginTransaction();
        
        // Hitung total harga
        $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
        $stmt = $pdo->prepare("SELECT SUM(price) FROM products WHERE id IN ($placeholders)");
        $stmt->execute($_SESSION['cart']);
        $total = $stmt->fetchColumn();
        
        // Buat transaksi
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, total_price, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $transaction_id = $pdo->lastInsertId();
        
        // Update status produk
        $stmt = $pdo->prepare("UPDATE products SET status = 'terjual' WHERE id IN ($placeholders)");
        $stmt->execute($_SESSION['cart']);
        
        // Kosongkan cart
        unset($_SESSION['cart']);
        
        $pdo->commit();
        
        $_SESSION['message'] = "Checkout successful! Transaction ID: #$transaction_id";
        header("Location: ../pages/profile.php");
        exit;
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Checkout failed: ".$e->getMessage();
        header("Location: ../pages/cart.php");
        exit;
    }
}
?>