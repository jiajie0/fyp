<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Game</h1>
    <div>
        @if (session()->has('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div>
        <div>
            <a href="{{ route('game.create') }}">Create a Game</a>
        </div>
        <table border="1">
            <tr>
                <th>DeveloperID</th>
                <th>GameID</th>
                <th>GameName</th>
                <th>GameDescription</th>
                <th>GameCategory</th>
                <th>GameUploadDate</th>
                <th>RatingScore</th>
                <th>GamePrice</th>
                <th>GameAchievementsCount</th>
                <th>GameAvatar</th> 
                <th>GameReferenceImages</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($game as $game)
                <tr>
                    <td>{{ $game->DeveloperID }}</td>
                    <td>{{ $game->GameID }}</td>
                    <td>{{ $game->GameName }}</td>
                    <td>{{ $game->GameDescription }}</td>
                    <td>{{ $game->GameCategory }}</td>
                    <td>{{ $game->GameUploadDate }}</td>
                    <td>{{ $game->RatingScore }}</td>
                    <td>{{ $game->GamePrice }}</td>
                    <td>{{ $game->GameAchievementsCount }}</td>
                    <td>
                        <!-- Display Game Avatar if available -->
                        @if($game->GameAvatar)
                            <img src="{{ $game->GameAvatar }}" alt="Game Avatar" style="width: 50px; height: auto;" />
                        @else
                            No Avatar
                        @endif
                    </td>
                    <td>
                        @if($game->GameReferenceImages)
                            @foreach($game->GameReferenceImages as $image)
                                <img src="{{ asset($image) }}" alt="Game Reference Image" style="width: 50px; height: auto;" />
                            @endforeach
                        @else
                            No Reference Images
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('game.edit', ['game' => $game]) }}">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{ route('game.delete', ['game' => $game]) }}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

</body>

</html>
