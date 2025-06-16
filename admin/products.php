<?php
include '../includes/header.php';
require_once '../config/database.php';

// Check if user is admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

// Handle product deletion
if(isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $_SESSION['message'] = "Product deleted successfully";
    header("Location: products.php");
    exit;
}

// Get all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-8 bg-dark">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Manage <span class="text-primary">Products</span></h1>
            <a href="add-product.php" class="bg-primary hover:bg-indigo-700 px-4 py-2 rounded-md transition">
                <i class="fas fa-plus mr-2"></i> Add Product
            </a>
        </div>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="bg-green-600 text-white p-3 rounded-md mb-6">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        
        <div class="bg-darker rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-gray-800">
                            <th class="p-4">ID</th>
                            <th class="p-4">Game</th>
                            <th class="p-4">Title</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                        <tr class="border-b border-gray-800 hover:bg-gray-900 transition">
                            <td class="p-4">#<?= $product['id'] ?></td>
                            <td class="p-4"><?= htmlspecialchars($product['game_name']) ?></td>
                            <td class="p-4">
                                <div class="flex items-center space-x-3">
                                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-10 h-10 object-cover rounded">
                                    <span><?= htmlspecialchars($product['title']) ?></span>
                                </div>
                            </td>
                            <td class="p-4">$<?= htmlspecialchars($product['price']) ?></td>
                            <td class="p-4">
                                <span class="<?= $product['status'] === 'tersedia' ? 'bg-green-600' : 'bg-red-600' ?> text-white px-2 py-1 rounded-full text-xs">
                                    <?= ucfirst($product['status']) ?>
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex space-x-2">
                                    <a href="edit-product.php?id=<?= $product['id'] ?>" class="bg-blue-600 hover:bg-blue-700 p-2 rounded transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="products.php?delete=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="bg-red-600 hover:bg-red-700 p-2 rounded transition">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>