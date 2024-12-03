<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Store</title>
</head>

<body>
    @auth('player')
        <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
            <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
            <p>Your ID: <strong>{{ Auth::guard('player')->user()->PlayerID }}</strong></p>
        </section>

        <h1>Your Games</h1>
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
                @foreach ($game_store as $game_store_item)
                    <tr>
                        <td>{{ $game_store_item->PlayerID }}</td>
                        <td>
                            @if ($game_store_item->game->GameAvatar)
                                <img src="{{ asset( $game_store_item->game->GameAvatar) }}" alt="Game Avatar" style="width: 50px; height: 50px;">
                            @else
                                No Avatar
                            @endif
                        </td>
                        <td>{{ $game_store_item->GameID }}</td>
                        <td>{{ $game_store_item->game->GameName }}</td>
                        <td>{{ $game_store_item->game->GameCategory }}</td>
                        <td>{{ $game_store_item->GameAchievementsCount }}</td>
                        <td>{{ $game_store_item->PlayerAchievementsCount }}</td>
                        <td>{{ $game_store_item->TotalPlayTime }}</td>
                        <td>
                            <form method="post"
                                action="{{ route('game_store.delete', ['playerID' => $game_store_item->PlayerID, 'gameID' => $game_store_item->GameID]) }}">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Delete" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <p>Please <a href="{{ route('player.login') }}">log in</a> to see your games.</p>
    @endauth
</body>

</html>
