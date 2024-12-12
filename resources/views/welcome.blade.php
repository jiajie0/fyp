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
            background-color: #f9f9f9;
        }

        .sidebar {
            width: 150px;
            background-color: #f4f4f4;
            padding: 20px;
            height: 100% box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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

        .sidebar ul li a:hover {
            color: #f39c12;
        }


        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .top-banner img {
            width: 100%;
            max-width: 800px;
            height: auto;
            border-radius: 10px;
        }

        .new-releases {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .game-card {
            width: 400px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .game-card img.reference-image {
            width: 90%;
            height: 200px;
            margin-left: 5%;
            margin-right: 5%;
            margin-top: 5%;
            object-fit: cover;
            border-radius: 10px;
        }

        .game-details {
            display: flex;
            align-items: center;
            padding: 10px;
            gap: 15px;
        }

        .game-avatar {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            margin-left: 9px;
        }

        .game-info {
            flex-grow: 1;
        }

        .game-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .game-meta {
            font-size: 14px;
            color: #888;
            margin: 5px 0;
        }

        .game-category {
            display: inline-block;
            padding: 5px 5px;
            background-color: #f0f0f0;
            margin-right: 2px;
            margin-bottom: 5px;
            border-radius: 10px;
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
                        <a href="{{ route('player.login') }}" class="text-lg font-medium text-black">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('player.register') }}" class="text-lg font-medium text-black">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
        <h1>Home</h1>
        @auth('player')
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </section>
        @else
            <p>Please <a href="{{ route('player.login') }}">log in</a> to see your details.</p>
        @endauth

        <div class="top-banner">
            <div id="carousel" class="carousel">
                @foreach ($event as $event)
                    <img class="carousel-image" src="{{ asset($event->EventImageURL) }}" alt="{{ $event->EventName }}"
                        style="display: none;">
                @endforeach
            </div>
        </div>

        <h2>Top New Releases</h2>
        <div class="new-releases">
            @foreach ($game as $game)
                <div class="game-card">
                    <!-- Make GameReferenceImages clickable -->
                    @if (!empty($game->GameReferenceImages) && is_array($game->GameReferenceImages))
                        <a href="{{ route('game.detail', ['game' => $game]) }}">
                            <img class="reference-image" src="{{ asset($game->GameReferenceImages[0]) }}"
                                alt="Game Reference Image" />
                        </a>
                    @else
                        <a href="{{ route('game.detail', ['game' => $game]) }}">
                            <img src="https://via.placeholder.com/400x200" alt="Game Reference Image" />
                        </a>
                    @endif

                    <!-- 游戏详细信息 -->
                    <div class="game-details">
                        <!-- Make GameAvatar clickable -->
                        @if ($game->GameAvatar)
                            <a href="{{ route('game.detail', ['game' => $game]) }}">
                                <img class="game-avatar" src="{{ asset($game->GameAvatar) }}" alt="Game Avatar" />
                            </a>
                        @else
                            <a href="{{ route('game.detail', ['game' => $game]) }}">
                                <img src="https://via.placeholder.com/60x60" src="{{ asset($game->GameAvatar) }}"
                                    alt="Game Avatar" />
                            </a>
                        @endif

                        <div class="game-info">
                            <p class="game-name">{{ $game->GameName }}</p>
                            <div class="game-meta">
                                @forelse (json_decode($game->GameCategory, true) as $category)
                                    <span class="game-category">{{ $category }}</span>
                                @empty
                                    <span class="game-category">{{ $game->GameCategory }}</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.carousel-image');
            let currentIndex = 0;

            if (images.length > 0) {
                // 显示第一张图片
                images[currentIndex].style.display = 'block';

                function showNextImage() {
                    // 隐藏当前图片
                    images[currentIndex].style.display = 'none';

                    // 计算下一张图片的索引
                    currentIndex = (currentIndex + 1) % images.length;

                    // 显示下一张图片
                    images[currentIndex].style.display = 'block';
                }

                // 每 3 秒切换一次图片
                setInterval(showNextImage, 3000);
            }
        });
    </script>
</body>

</html>
