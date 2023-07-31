<!-- resources/views/auth/custom-login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="../css/app.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="relative w-full h-screen bg-black overflow-hidden">
        <img src="/images/bg_login.jpg" alt="" class="relative h-full w-[100%]">
        <div class="absolute h-full w-full z-20 top-0 grid place-items-center">
            <div class="w-full lg:w-[30rem] bg-white p-10 rounded-xl shadow-lg">
                <img src="/images/logo.png" alt="" class="w-[20rem] mx-auto">
                <form method="POST" action="{{ url('/auth/login') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-gray-500">Email</label>
                        <input type="email" name="email" id="email" class="w-full border border-gray-400 rounded-lg" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="text-sm font-semibold text-gray-500">Password:</label>
                        <input type="password" name="password" id="password" class="w-full border border-gray-400 rounded-lg" required>
                    </div>
                    <button type="submit" class="w-full py-3 text-center bg-blue-500 text-white hover:bg-blue-600 rounded-lg">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
