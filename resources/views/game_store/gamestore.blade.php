<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    </style>
    <title>Game Store</title>
</head>

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
    <div class="sidebar">
        @auth('player')
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
                <p>Your Level: <strong>{{ Auth::guard('player')->user()->PlayerLevel }}</strong></p>
                <p>Your Score: <strong>{{ Auth::guard('player')->user()->PlayerScore }}</strong></p>
            </section>

            <h1>YourGames</h1>
            <div>
                @if (session()->has('success'))
                    <div>
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div>
                <table border="1">
                    <tr>
                        <th>PlayerID</th>
                        <th>GameAvatar</th>
                        <th>GameID</th>
                        <th>GameName</th>
                        <th>GameCategory</th>
                        <th>GameAchievementsCount</th>
                        <th>PlayerAchievementsCount</th>
                        <th>TotalPlayTime</th>
                        <th>Delete</th>
                    </tr>
                    @foreach ($game_store as $game_store)
                        <tr>
                            <td>{{ $game_store->PlayerID }}</td>
                            <td>
                                @if ($game_store->game->GameAvatar)
                                    <img src="{{ asset($game_store->game->GameAvatar) }}" alt="Game Avatar"
                                        style="width: 50px; height: 50px;">
                                @else
                                    No Avatar
                                @endif
                            </td>
                            <td>{{ $game_store->GameID }}</td>
                            <td>{{ $game_store->game->GameName }}</td>
                            <td>{{ $game_store->game->GameCategory }}</td>
                            <td>{{ $game_store->GameAchievementsCount }}</td>
                            <td>{{ $game_store->PlayerAchievementsCount }}</td>
                            <td>{{ $game_store->TotalPlayTime }}</td>
                            <td>
                                <form method="post"
                                    action="{{ route('game_store.delete', ['playerID' => $game_store->PlayerID, 'gameID' => $game_store->GameID]) }}">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Delete" />
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('game.addHour', ['gameId' => $game_store->GameID]) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add 1 Hour</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('game-store.add-achievement', ['gameId' => $game_store->GameID]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add 1 Achievement</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <p>Please <a href="{{ route('player.login') }}">log in</a> to see your games.</p>
        @endauth
    </div>
</body>

</html>
