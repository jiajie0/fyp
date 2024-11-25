<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Game</title>
</head>

<body>
    <h1>Edit a Game</h1>

    <div>
        @if($errors->any())  <!-- List out errors the user makes -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <form method="post" action="{{ route('game.update', ['game' => $game]) }}" enctype="multipart/form-data">  <!-- Added enctype for file upload -->
        @csrf  <!-- For security purposes -->
        @method('put')  <!-- Indicating this is a PUT request for updating data -->

        <div>
            <label for="DeveloperID">DeveloperID</label>
            <input type="text" name="DeveloperID" id="DeveloperID" placeholder="Enter Developer ID" value="{{ $game->DeveloperID }}" />
        </div>

        <div>
            <label for="GameName">GameName</label>
            <input type="text" name="GameName" id="GameName" placeholder="Enter Game Name" value="{{ $game->GameName }}" />
        </div>

        <div>
            <label for="GameDescription">GameDescription</label>
            <input type="text" name="GameDescription" id="GameDescription" placeholder="Enter Game Description" value="{{ $game->GameDescription }}" />
        </div>

        <div>
            <label for="GameCategory">GameCategory</label>
            <input type="text" name="GameCategory" id="GameCategory" placeholder="Enter Game Category" value="{{ $game->GameCategory }}" />
        </div>

        <div>
            <label for="GamePrice">GamePrice</label>
            <input type="text" name="GamePrice" id="GamePrice" placeholder="Enter Game Price" value="{{ $game->GamePrice }}" />
        </div>

        <div>
            <label for="GameAchievementsCount">GameAchievementsCount</label>
            <input type="text" name="GameAchievementsCount" id="GameAchievementsCount" placeholder="Enter Achievements Count" value="{{ $game->GameAchievementsCount }}" />
        </div>

        <!-- GameAvatar upload field -->
        <div>
            <label for="GameAvatar">Game Avatar</label>
            <input type="file" name="GameAvatar" id="GameAvatar" accept="image/*" />
        </div>

        <!-- Display current avatar if exists -->
        @if($game->GameAvatar)
            <div>
                <p>Current Avatar:</p>
                <img src="{{ $game->GameAvatar }}" alt="Game Avatar" style="width: 150px; height: auto;" />
            </div>
        @endif

        <div>
            <input type="submit" value="Update Game">
        </div>
    </form>
</body>

</html>
