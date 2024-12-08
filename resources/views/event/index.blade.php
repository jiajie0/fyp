<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Event</h1>
    <div>
        @if (session()->has('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div>
        <div>
            <a href="{{ route('event.create') }}">Create a Event</a>
        </div>
        <table border="1">
            <tr>
                <th>StaffID</th>
                <th>EventID</th>
                <th>EventName</th>
                <th>EventImageURL</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($event as $event)
                <tr>
                    <td>{{ $event->StaffID }}</td>
                    <td>{{ $event->EventID }}</td>
                    <td>{{ $event->EventName }}</td>
                    <td>
                        <!-- Display Event Avatar if available -->
                        @if($event->EventImageURL)
                            <img src="{{ $event->EventImageURL }}" alt="Event Avatar" style="width: 50px; height: auto;" />
                        @else
                            No Avatar
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('event.edit', ['event' => $event]) }}">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{ route('event.delete', ['event' => $event]) }}">
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
