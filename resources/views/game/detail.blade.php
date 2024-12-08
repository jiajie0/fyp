<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Details</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background-color: #f9f9f9;
        }

        .sidebar {
            width: 200px;
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

        .home-icon {
            color: yellow;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .top-banner img {
            width: 90%;
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

        .nav-bar {
            margin-bottom: 20px;
        }
    </style>

<body>
    <div class="sidebar">
        <h2>fyp app</h2>
        <ul>
            <li><a href="{{ route('welcome') }}"><i class="ri-home-line"></i> Home</a></li>
            <li><a href="#"><i class="ri-trophy-line"></i> Rating</a></li>
            <li><a href="#"><i class="ri-star-line"></i> Recommended</a></li>
            <li><a href="#"><i class="ri-arrow-up-line"></i> Update</a></li>
            <li><a href="{{ route('game_store.index') }}"><i class="ri-gamepad-line"></i> My Game</a></li>
            <li><a href="#"><i class="ri-settings-line"></i> Settings</a></li>
        </ul>
    </div>
    <div>
        <h1>Game Details</h1>
        @auth('player')
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
                <p>Your ID: <strong>{{ Auth::guard('player')->user()->PlayerID }}</strong></p>
            </section>
        @else
            <p>Please <a href="{{ route('player.login') }}">log in</a> to see your details.</p>
        @endauth
        @if ($errors->any())
            <!-- List out errors the user makes -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif


        <div>
            <p><strong>Developer Name:</strong> {{ $developerName }}</p>
            <p><strong>Game Name:</strong> {{ $game->GameName }}</p>
            <p><strong>Game Description:</strong> {{ $game->GameDescription }}</p>
            <p><strong>Game Category:</strong> {{ $game->GameCategory }}</p>
            <p><strong>Game Price:</strong> {{ $game->GamePrice }}</p>
            <p><strong>Achievements Count:</strong> {{ $game->GameAchievementsCount }}</p>

            <!-- Display current avatar if exists -->
            @if ($game->GameAvatar)
                <div>
                    <img src="{{ asset($game->GameAvatar) }}" alt="{{ $game->GameName }}" style="max-width: 300px;">
                </div>
            @endif

            @auth('player')
                <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                    <form action="{{ route('game.addToStore', $game->GameID) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Game Store</button>
                    </form>
                </section>
            @else
                <p>Please <a href="{{ route('player.login') }}">log in</a> to add games to the store.</p>
            @endauth

            @auth('player')
                @if ($playerRating)
                    <!-- 显示玩家的评论 -->
                    <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                        <h2>Your Review</h2>
                        <div class="review mb-4 p-3 border rounded">
                            <p>
                                <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>
                                @if ($playerRating->RatingMark)
                                    <span style="color: green;">Recommended</span>
                                @else
                                    <span style="color: red;">Not Recommended</span>
                                @endif
                            </p>
                            <p><em>{{ $playerRating->RatingText }}</em></p>
                            <p class="text-muted">Rated on
                                {{ \Carbon\Carbon::parse($playerRating->RatingTime)->format('Y-m-d H:i:s') }}</p>
                            <div>
                                <a href="{{ route('game.editRating', $playerRating->RatingID) }}"
                                    class="btn btn-secondary">Edit</a>
                                <form action="{{ route('game.deleteRating', $playerRating->RatingID) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </section>
                @else
                    <!-- 显示评论表单 -->
                    <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                        <h2>Rate This Game</h2>
                        <form action="{{ route('game.rate', $game->GameID) }}" method="POST">
                            @csrf
                            <div>
                                <label>
                                    <input type="radio" name="RatingMark" value="1" required>
                                    Recommend
                                </label>
                                <label>
                                    <input type="radio" name="RatingMark" value="0">
                                    Do Not Recommend
                                </label>
                            </div>
                            <div>
                                <label for="RatingText">Why?</label><br>
                                <textarea name="RatingText" id="RatingText" rows="4" placeholder="Write your reason here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                        </form>
                    </section>
                @endif
            @endauth
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <h2>Player Reviews</h2>

                @if ($ratings->isEmpty())
                    <p>No reviews yet. Be the first to rate this game!</p>
                @else
                    @foreach ($ratings as $rating)
                        <div class="review mb-4 p-3 border rounded">
                            <p>
                                <strong>{{ $rating->player->PlayerName }}</strong>
                                @if ($rating->RatingMark)
                                    <span style="color: green;">Recommended</span>
                                @else
                                    <span style="color: red;">Not Recommended</span>
                                @endif
                            </p>
                            <p><em>{{ $rating->RatingText }}</em></p>
                            <p class="text-muted">Rated on
                                {{ \Carbon\Carbon::parse($rating->RatingTime)->format('Y-m-d H:i:s') }}</p>
                        </div>
                    @endforeach
                @endif
            </section>
        </div>
    </div>
</body>

</html>
