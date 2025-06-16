<?php 
include '../includes/header.php';

if(!isset($_SESSION['payment_success'])) {
    header("Location: products.php");
    exit;
}

unset($_SESSION['payment_success']);
?>

<section class="min-h-screen flex items-center justify-center bg-dark py-12">
    <div class="bg-darker rounded-lg shadow-xl overflow-hidden w-full max-w-2xl">
        <div class="bg-gradient-to-r from-green-500 to-accent p-6 text-center">
            <i class="fas fa-check-circle text-5xl text-white mb-4"></i>
            <h2 class="text-2xl font-bold text-white">Payment Successful!</h2>
            <p class="text-white opacity-90">Thank you for your purchase</p>
        </div>
        
        <div class="p-8 text-center">
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Your order is being processed</h3>
                <p class="text-gray-400">We've sent the account details to your email address.</p>
            </div>
            
            <div class="bg-gray-900 rounded-lg p-6 mb-6 text-left">
                <h4 class="font-semibold mb-4">What's next?</h4>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span>Check your email for account details (including spam folder)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-headset text-blue-500 mt-1 mr-2"></i>
                        <span>Contact support if you don't receive details within 24 hours</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-shield-alt text-primary mt-1 mr-2"></i>
                        <span>Change account password immediately after login</span>
                    </li>
                </ul>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="profile.php" class="bg-primary hover:bg-indigo-700 px-6 py-3 rounded-md font-medium transition">
                    View Order History
                </a>
                <a href="products.php" class="border border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-md font-medium transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>