<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OwlSaint Store - Premium Game Accounts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        dark: '#1F2937',
                        darker: '#111827',
                        accent: '#10B981',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-darker text-gray-100 font-sans">
    <header class="bg-dark shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="../index.php" class="flex items-center space-x-2">
                <span class="text-2xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">OwlSaint</span>
            </a>
            
            <nav class="hidden md:flex space-x-8">
                <a href="/owlsaint/" class="hover:text-primary transition">Home</a>
                <a href="/owlsaint/pages/products.php" class="hover:text-primary transition">Products</a>
                <a href="#" class="hover:text-primary transition">About</a>
                <a href="#" class="hover:text-primary transition">Contact</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="../pages/profile.php" class="flex items-center space-x-2 hover:text-primary transition">
                        <i class="fas fa-user-circle text-xl"></i>
                        <span><?= htmlspecialchars($_SESSION['username']) ?></span>
                    </a>
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <a href="/owlsaint/admin/dashboard.php" class="bg-primary hover:bg-indigo-700 px-4 py-2 rounded-md transition">Admin</a>
                    <?php endif; ?>
                    <a href="/owlsaint/includes/auth.php?action=logout" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md transition">Logout</a>
                <?php else: ?>
                    <a href="/owlsaint/pages/login.php" class="hover:text-primary transition">Login</a>
                    <a href="/owlsaint/pages/register.php" class="bg-primary hover:bg-indigo-700 px-4 py-2 rounded-md transition">Register</a>
                <?php endif; ?>
                <button id="mobile-menu-button" class="md:hidden text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-dark pb-4 px-4">
            <a href="../index.php" class="block py-2 hover:text-primary transition">Home</a>
            <a href="../pages/products.php" class="block py-2 hover:text-primary transition">Products</a>
            <a href="#" class="block py-2 hover:text-primary transition">About</a>
            <a href="#" class="block py-2 hover:text-primary transition">Contact</a>
        </div>
    </header>
    
    <main class="min-h-screen">