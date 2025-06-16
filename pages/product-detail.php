<?php 
include '../includes/header.php';
require_once '../config/database.php';

if(!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product) {
    header("Location: products.php");
    exit;
}
?>

<section class="py-12 bg-dark">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/2">
                <div class="bg-darker rounded-lg overflow-hidden mb-4">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-full h-96 object-cover">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="bg-darker rounded-lg overflow-hidden h-24 cursor-pointer border-2 border-transparent hover:border-primary transition">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-darker rounded-lg overflow-hidden h-24 cursor-pointer border-2 border-transparent hover:border-primary transition">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-darker rounded-lg overflow-hidden h-24 cursor-pointer border-2 border-transparent hover:border-primary transition">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            
            <div class="md:w-1/2">
                <div class="bg-darker rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="bg-primary text-white text-xs font-bold px-2 py-1 rounded mb-2 inline-block">
                                <?= htmlspecialchars($product['game_name']) ?>
                            </span>
                            <h1 class="text-2xl font-bold"><?= htmlspecialchars($product['title']) ?></h1>
                        </div>
                        <div class="text-3xl font-bold text-primary">$<?= htmlspecialchars($product['price']) ?></div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-400">(24 reviews)</span>
                        </div>
                        <div class="flex items-center space-x-4 text-gray-400 text-sm">
                            <span><i class="fas fa-check-circle text-green-500 mr-1"></i> Verified Account</span>
                            <span><i class="fas fa-shield-alt text-blue-500 mr-1"></i> Secure Delivery</span>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-400"><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Account Details</h3>
                        <ul class="text-gray-400 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Level: 100+</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>All characters unlocked</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Premium skins included</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Email change available</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="flex space-x-4">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <form action="../includes/process_order.php" method="POST" class="w-full">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="w-full bg-primary hover:bg-indigo-700 px-6 py-3 rounded-md font-medium transition">
                                    Buy Now
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="../pages/login.php" class="w-full bg-primary hover:bg-indigo-700 px-6 py-3 rounded-md font-medium transition text-center">
                                Login to Purchase
                            </a>
                        <?php endif; ?>
                        <button class="bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-md font-medium transition">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 bg-darker rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Customer <span class="text-primary">Reviews</span></h2>
            
            <div class="space-y-6">
                <div class="border-b border-gray-800 pb-6">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="font-medium">JohnDoe123</span>
                        </div>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-400">Great account! Everything was as described and the delivery was super fast. Will definitely buy again from OwlSaint.</p>
                    <span class="text-gray-500 text-sm">June 10, 2025</span>
                </div>
                
                <div class="border-b border-gray-800 pb-6">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="font-medium">GameLover42</span>
                        </div>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-400">Account works perfectly. Only issue was the email change took a bit longer than expected, but support was helpful.</p>
                    <span class="text-gray-500 text-sm">June 5, 2025</span>
                </div>
            </div>
            
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Write a Review</h3>
                <form>
                    <div class="mb-4">
                        <label class="block text-gray-400 mb-2">Rating</label>
                        <div class="flex space-x-1">
                            <i class="far fa-star text-2xl text-yellow-400 cursor-pointer"></i>
                            <i class="far fa-star text-2xl text-yellow-400 cursor-pointer"></i>
                            <i class="far fa-star text-2xl text-yellow-400 cursor-pointer"></i>
                            <i class="far fa-star text-2xl text-yellow-400 cursor-pointer"></i>
                            <i class="far fa-star text-2xl text-yellow-400 cursor-pointer"></i>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-400 mb-2">Review</label>
                        <textarea class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary" rows="4"></textarea>
                    </div>
                    <button type="submit" class="bg-primary hover:bg-indigo-700 px-6 py-2 rounded-md font-medium transition">Submit Review</button>
                </form>
            </div>
            <?php else: ?>
            <div class="mt-8 text-center py-6 border-t border-gray-800">
                <p class="text-gray-400">You must be <a href="../pages/login.php" class="text-primary hover:underline">logged in</a> to write a review.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>