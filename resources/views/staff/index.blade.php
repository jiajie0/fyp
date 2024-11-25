<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Staff</h1>
    <div>
        @if (session()->has('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div>
        <div>
            <a href="{{ route('staff.create') }}">Create a Staff</a>
        </div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($staff as $staff)
                <tr>
                    <td>{{ $staff->StaffID }}</td>
                    <td>{{ $staff->name }}</td>
                    <td>{{ $staff->qty }}</td>
                    <td>{{ $staff->price }}</td>
                    <td>{{ $staff->description }}</td>
                    <td>
                        <a href="{{ route('staff.edit', ['staff' => $staff]) }}">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{ route('staff.delete', ['staff' => $staff]) }}">
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
