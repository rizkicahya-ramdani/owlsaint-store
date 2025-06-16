<?php
include '../includes/header.php';
require_once '../config/database.php';

// Check if user is admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

// Get stats
$usersCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$productsCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$transactionsCount = $pdo->query("SELECT COUNT(*) FROM transactions")->fetchColumn();
$revenue = $pdo->query("SELECT SUM(total_price) FROM transactions WHERE status = 'completed'")->fetchColumn();
?>

<section class="py-8 bg-dark">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Admin <span class="text-primary">Dashboard</span></h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-darker rounded-lg p-6 shadow-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400">Total Users</h3>
                        <p class="text-3xl font-bold"><?= $usersCount ?></p>
                    </div>
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-users text-primary text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <a href="users.php" class="text-primary hover:underline text-sm">View all users</a>
                </div>
            </div>
            
            <div class="bg-darker rounded-lg p-6 shadow-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400">Total Products</h3>
                        <p class="text-3xl font-bold"><?= $productsCount ?></p>
                    </div>
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-gamepad text-primary text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <a href="products.php" class="text-primary hover:underline text-sm">Manage products</a>
                </div>
            </div>
            
            <div class="bg-darker rounded-lg p-6 shadow-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400">Total Transactions</h3>
                        <p class="text-3xl font-bold"><?= $transactionsCount ?></p>
                    </div>
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-exchange-alt text-primary text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <a href="transactions.php" class="text-primary hover:underline text-sm">View transactions</a>
                </div>
            </div>
            
            <div class="bg-darker rounded-lg p-6 shadow-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-400">Total Revenue</h3>
                        <p class="text-3xl font-bold">$<?= number_format($revenue ?: 0, 2) ?></p>
                    </div>
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-primary text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <a href="transactions.php" class="text-primary hover:underline text-sm">View sales report</a>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-darker rounded-lg p-6 shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Recent Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b border-gray-800">
                                <th class="pb-2">ID</th>
                                <th class="pb-2">User</th>
                                <th class="pb-2">Amount</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT t.id, u.username, t.total_price, t.status 
                                                 FROM transactions t 
                                                 JOIN users u ON t.user_id = u.id 
                                                 ORDER BY t.transaction_date DESC 
                                                 LIMIT 5");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            ?>
                            <tr class="border-b border-gray-800 hover:bg-gray-900 transition">
                                <td class="py-3">#<?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td>$<?= number_format($row['total_price'], 2) ?></td>
                                <td>
                                    <span class="<?= 
                                        $row['status'] === 'completed' ? 'bg-green-600' : 
                                        ($row['status'] === 'pending' ? 'bg-yellow-600' : 'bg-red-600') 
                                    ?> text-white px-2 py-1 rounded-full text-xs">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <a href="transactions.php" class="text-primary hover:underline text-sm">View all transactions</a>
                </div>
            </div>
            
            <div class="bg-darker rounded-lg p-6 shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Recent Products</h3>
                <div class="space-y-4">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 3");
                    while($product = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <div class="flex items-center space-x-4 border-b border-gray-800 pb-4">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-16 h-16 object-cover rounded">
                        <div>
                            <h4 class="font-medium"><?= htmlspecialchars($product['title']) ?></h4>
                            <p class="text-gray-400 text-sm"><?= htmlspecialchars($product['game_name']) ?></p>
                            <p class="text-primary font-bold">$<?= htmlspecialchars($product['price']) ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800">
                    <a href="products.php" class="text-primary hover:underline text-sm">View all products</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>