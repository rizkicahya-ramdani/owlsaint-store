<?php include '../includes/header.php'; ?>

<section class="min-h-screen flex items-center justify-center bg-dark py-12">
    <div class="bg-darker rounded-lg shadow-xl overflow-hidden w-full max-w-md">
        <div class="bg-gradient-to-r from-primary to-accent p-6 text-center">
            <h2 class="text-2xl font-bold text-white">Create Account</h2>
            <p class="text-white opacity-90">Join OwlSaint community</p>
        </div>
        
        <div class="p-6">
            <?php if(isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
                <div class="bg-red-600 text-white p-3 rounded-md mb-4">
                    Username or email already exists. Please try different ones.
                </div>
            <?php elseif(isset($_GET['error']) && $_GET['error'] === 'unknown'): ?>
                <div class="bg-red-600 text-white p-3 rounded-md mb-4">
                    An error occurred. Please try again later.
                </div>
            <?php endif; ?>
            
            <form action="../includes/auth.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-400 mb-2">Username</label>
                    <input type="text" id="username" name="username" required 
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-400 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-400 mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-gray-400 mb-2">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" required 
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-700 rounded bg-gray-800">
                        <label for="terms" class="ml-2 text-gray-400 text-sm">
                            I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                </div>
                
                <button type="submit" name="register" class="w-full bg-primary hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition mb-4">
                    Register
                </button>
                
                <div class="text-center text-gray-400">
                    Already have an account? <a href="login.php" class="text-primary hover:underline">Login</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>