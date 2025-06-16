<?php 
include '../includes/header.php';
require_once '../config/database.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil produk di cart
$cart_products = [];
$total = 0;

if(!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($_SESSION['cart']);
    $cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $total = array_sum(array_column($cart_products, 'price'));
}
?>

<section class="py-12 bg-dark">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Your <span class="text-primary">Cart</span></h1>
        
        <?php if(empty($cart_products)): ?>
            <div class="bg-darker rounded-lg p-8 text-center">
                <i class="fas fa-shopping-cart text-5xl text-gray-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Your cart is empty</h3>
                <p class="text-gray-400 mb-4">Browse our products and add some items to your cart</p>
                <a href="../pages/products.php" class="bg-primary hover:bg-indigo-700 px-6 py-3 rounded-md font-medium transition inline-block">Shop Now</a>
            </div>
        <?php else: ?>
            <div class="bg-darker rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 p-6">
                        <div class="divide-y divide-gray-800">
                            <?php foreach($cart_products as $product): ?>
                            <div class="py-4 flex flex-col md:flex-row items-start md:items-center">
                                <div class="flex items-center space-x-4 mb-4 md:mb-0 md:w-1/2">
                                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-20 h-20 object-cover rounded">
                                    <div>
                                        <h3 class="font-semibold"><?= htmlspecialchars($product['title']) ?></h3>
                                        <p class="text-gray-400 text-sm"><?= htmlspecialchars($product['game_name']) ?></p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center w-full md:w-1/2">
                                    <span class="text-xl font-bold text-primary">$<?= htmlspecialchars($product['price']) ?></span>
                                    <a href="../includes/cart.php?remove=<?= $product['id'] ?>" class="text-red-500 hover:text-red-400 transition">
                                        <i class="fas fa-trash"></i> Remove
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="bg-gray-900 p-6">
                        <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Subtotal</span>
                                <span>$<?= number_format($total, 2) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Service Fee</span>
                                <span>$0.00</span>
                            </div>
                            <div class="border-t border-gray-800 pt-4 flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-primary">$<?= number_format($total, 2) ?></span>
                            </div>
                        </div>
                        
                        <form action="../includes/cart.php" method="POST" class="mt-6">
                            <button type="submit" name="checkout" class="w-full bg-primary hover:bg-indigo-700 px-6 py-3 rounded-md font-medium transition mb-4">
                                Proceed to Checkout
                            </button>
                            <a href="../pages/products.php" class="block text-center border border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-md font-medium transition">
                                Continue Shopping
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include '../includes/footer.php'; ?>