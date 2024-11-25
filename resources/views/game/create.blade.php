<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a Game</title>
</head>

<body>
    <h1>Create a Game</h1>

    <div>
        @if($errors->any()) <!-- List out errors if user makes any mistake -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <form method="post" action="{{ route('game.store') }}" enctype="multipart/form-data">
        @csrf <!-- For security purposes -->
        @method('post')

        <input type="hidden" name="DeveloperID" value="{{ $developerID }}" />

        <div>
            <label for="GameName">GameName</label>
            <input type="text" name="GameName" id="GameName" placeholder="Enter Game Name" />
        </div>

        <div>
            <label for="GameDescription">GameDescription</label>
            <input type="text" name="GameDescription" id="GameDescription" placeholder="Enter Game Description" />
        </div>

        <div>
            <label for="GameCategory">GameCategory</label>
            <input type="text" name="GameCategory" id="GameCategory" placeholder="Enter Game Category" />
        </div>

        <div>
            <label for="GamePrice">GamePrice</label>
            <input type="text" name="GamePrice" id="GamePrice" placeholder="Enter Game Price" />
        </div>

        <div>
            <label for="GameAchievementsCount">GameAchievementsCount</label>
            <input type="text" name="GameAchievementsCount" id="GameAchievementsCount" placeholder="Enter Achievements Count" />
        </div>

        <!-- GameAvatar field -->
        <div>
            <label for="GameAvatar">GameAvatar</label>
            <input type="file" name="GameAvatar" id="GameAvatar" accept="image/*" />
        </div>

        <div>
            <input type="submit" value="Save New Game">
        </div>
    </form>
</body>

</html>
