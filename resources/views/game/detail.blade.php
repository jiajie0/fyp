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

    </div>
</body>

</html>
