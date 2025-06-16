<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Simulasikan pembayaran berhasil
$transaction_id = 'TXN-' . uniqid();
$payment_method = 'Credit Card';
$payment_amount = array_sum(array_column($_SESSION['cart_products'], 'price'));

// Simpan ke database
try {
    $pdo->beginTransaction();
    
    // Buat record pembayaran
    $stmt = $pdo->prepare("INSERT INTO payments (transaction_id, user_id, amount, method, status) VALUES (?, ?, ?, ?, 'completed')");
    $stmt->execute([$transaction_id, $_SESSION['user_id'], $payment_amount, $payment_method]);
    
    // Update status transaksi
    $stmt = $pdo->prepare("UPDATE transactions SET status = 'completed' WHERE id = ?");
    $stmt->execute([$_SESSION['current_transaction_id']]);
    
    $pdo->commit();
    
    // Kirim email (simulasi)
    $to = $_SESSION['email'];
    $subject = "Payment Confirmation - $transaction_id";
    $message = "Thank you for your purchase!\n\n";
    $message .= "Transaction ID: $transaction_id\n";
    $message .= "Amount: $$payment_amount\n";
    $message .= "Payment Method: $payment_method\n\n";
    $message .= "Account details will be sent in a separate email.";
    
    // mail($to, $subject, $message); // Uncomment untuk produksi
    
    $_SESSION['payment_success'] = true;
    header("Location: ../pages/payment_success.php");
    exit;
    
} catch(Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Payment failed: " . $e->getMessage();
    header("Location: ../pages/checkout.php");
    exit;
}
?>