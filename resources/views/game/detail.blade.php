<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Details</title>
</head>

<body>
    <h1>Game Details</h1>

    @if($errors->any())
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

        <!-- Display current avatar if it exists -->
        @if($game->GameAvatar)
            <div>
                <p><strong>Current Avatar:</strong></p>
                <img src="{{ $game->GameAvatar }}" alt="Game Avatar" style="width: 150px; height: auto;" />
            </div>
        @else
            <p>No avatar available.</p>
        @endif
    </div>
</body>

</html>
