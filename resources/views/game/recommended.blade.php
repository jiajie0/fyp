<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Games</title>
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
    <h1>Recommended Games</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Game Name</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recommendations as $index => $recommendation)
                @if (is_object($recommendation) && isset($recommendation->GameName) && isset($recommendation->GameCategory))
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $recommendation->GameName }}</td>
                        <td>{{ implode(', ', json_decode($recommendation->GameCategory, true)) }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="3">No recommended games available at this time.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
