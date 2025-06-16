<?php include '../includes/header.php'; ?>

<section class="min-h-screen flex items-center justify-center bg-dark py-12">
    <div class="bg-darker rounded-lg shadow-xl overflow-hidden w-full max-w-md">
        <div class="bg-gradient-to-r from-primary to-accent p-6 text-center">
            <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
            <p class="text-white opacity-90">Login to your OwlSaint account</p>
        </div>
        
        <div class="p-6">
            <?php if(isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
                <div class="bg-red-600 text-white p-3 rounded-md mb-4">
                    Invalid email or password. Please try again.
                </div>
            <?php elseif(isset($_GET['registration']) && $_GET['registration'] === 'success'): ?>
                <div class="bg-green-600 text-white p-3 rounded-md mb-4">
                    Registration successful! Please login with your credentials.
                </div>
            <?php endif; ?>
            
            <form action="../includes/auth.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-400 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-400 mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-700 rounded bg-gray-800">
                        <label for="remember" class="ml-2 text-gray-400">Remember me</label>
                    </div>
                    <a href="#" class="text-primary hover:underline">Forgot password?</a>
                </div>
                
                <button type="submit" name="login" class="w-full bg-primary hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition mb-4">
                    Login
                </button>
                
                <div class="text-center text-gray-400">
                    Don't have an account? <a href="register.php" class="text-primary hover:underline">Register</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>