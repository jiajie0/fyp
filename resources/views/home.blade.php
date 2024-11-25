<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Game Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-white"> <!-- 设置背景为白色，去掉 dark 类 -->
    <div class="container mx-auto p-6">
        <header class="flex justify-between items-center py-4">
            <h1 class="text-3xl font-bold text-red-600">Game Platform</h1>
            @if (Route::has('login'))
                <nav class="flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-lg font-medium text-black">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-lg font-medium text-black">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-lg font-medium text-black">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="grid gap-8 mt-8 md:grid-cols-2 lg:grid-cols-3">
            <a href="/games" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                <h2 class="text-2xl font-semibold text-red-600">Explore Games</h2>
                <p class="mt-2 text-gray-600">Discover the latest and most popular games on our platform.</p>
            </a>

            <a href="/news" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                <h2 class="text-2xl font-semibold text-red-600">Game News</h2>
                <p class="mt-2 text-gray-600">Stay updated with the latest news and updates in the gaming world.</p>
            </a>

            <a href="/community" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                <h2 class="text-2xl font-semibold text-red-600">Community</h2>
                <p class="mt-2 text-gray-600">Join discussions, share tips, and connect with fellow gamers.</p>
            </a>

            <a href="/tutorials" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                <h2 class="text-2xl font-semibold text-red-600">Tutorials</h2>
                <p class="mt-2 text-gray-600">Learn to play like a pro with comprehensive guides and tutorials.</p>
            </a>

            <a href="/leaderboards" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                <h2 class="text-2xl font-semibold text-red-600">Leaderboards</h2>
                <p class="mt-2 text-gray-600">Check out the top players and compete for high scores.</p>
            </a>
        </main>

        <footer class="mt-12 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Game Platform. All rights reserved.
        </footer>
    </div>
</body>

</html>
