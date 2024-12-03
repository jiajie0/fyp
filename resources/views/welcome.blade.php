<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            padding: 20px;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a .icon {
            margin-right: 10px;
        }

        .home-icon {
            color: yellow;
            /* 设置图标颜色为黄色 */
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .top-banner img {
            width: 100%;
            border-radius: 10px;
        }

        .new-releases {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .game-card {
            width: 150px;
            border-radius: 10px;
            overflow: hidden;
        }

        .game-card img {
            width: 100%;
            display: block;
        }

        .nav-bar {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>fyp app</h2>
        <ul>
            <li><a href="#"><i class="ri-home-line"></i> Home</a></li>
            <li><a href="#"><i class="ri-trophy-line"></i> Rating</a></li>
            <li><a href="#"><i class="ri-star-line"></i> Recommended</a></li>
            <li><a href="#"><i class="ri-arrow-up-line"></i> Update</a></li>
            <li><a href="{{ route('game_store.index') }}"><i class="ri-gamepad-line"></i> My Game</a></li>
            <li><a href="#"><i class="ri-settings-line"></i> Settings</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="nav-bar">
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
        </div>
        <h1>Home</h1>
        @auth('player')
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
                <p>Your ID: <strong>{{ Auth::guard('player')->user()->PlayerID }}</strong></p>
            </section>
        @else
            <p>Please <a href="{{ route('player.login') }}">log in</a> to see your details.</p>
        @endauth
        <div class="top-banner">
            <img src="https://via.placeholder.com/800x300" alt="Top Banner">
        </div>
        <h2>Top New Releases</h2>
        <div class="new-releases">
            @foreach ($game as $game)
                <div class="game-card">
                    <a href="{{ route('game.detail', ['game' => $game]) }}">
                        <img src="{{ $game->GameAvatar }}" alt="{{ $game->GameName }}">
                    </a>
                    <p>{{ $game->GameName }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
