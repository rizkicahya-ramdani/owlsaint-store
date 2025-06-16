<?php 
include '../includes/header.php';
require_once '../config/database.php';

// Get all available products
$stmt = $pdo->query("SELECT * FROM products WHERE status = 'tersedia'");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-12 bg-dark">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Our <span class="text-primary">Products</span></h1>
            
            <div class="flex space-x-4">
                <div class="relative">
                    <select class="bg-darker border border-gray-700 rounded-md px-4 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>All Games</option>
                        <option>Valorant</option>
                        <option>Genshin Impact</option>
                        <option>League of Legends</option>
                        <option>Fortnite</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                </div>
                
                <div class="relative">
                    <select class="bg-darker border border-gray-700 rounded-md px-4 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Sort by: Newest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Popularity</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($products as $product): ?>
            <div class="bg-darker rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="relative">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-full h-48 object-cover">
                    <div class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded">
                        <?= htmlspecialchars($product['game_name']) ?>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($product['title']) ?></h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2"><?= htmlspecialchars($product['description']) ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-primary">$<?= htmlspecialchars($product['price']) ?></span>
                        <a href="product-detail.php?id=<?= $product['id'] ?>" class="bg-primary hover:bg-indigo-700 px-4 py-2 rounded-md transition">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($products)): ?>
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-gamepad text-5xl text-gray-600 mb-4"></i>
                    <h3 class="text-xl font-semibold">No products available at the moment</h3>
                    <p class="text-gray-400">Check back later for new game accounts!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>