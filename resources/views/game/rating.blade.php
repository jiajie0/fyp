<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Ranking</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Game Ranking</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Game Name</th>
                <th>Rating Score</th>
                <th>Developer ID</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($games as $index => $game)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $game->GameName }}</td>
                    <td>{{ $game->RatingScore }}</td>
                    <td>{{ $game->DeveloperID }}</td>
                    <td>${{ number_format($game->GamePrice, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No games available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
