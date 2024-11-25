<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Edit a staff</h1>
    <div>
        @if($errors->any())  <!-- list out error user make-->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <form method="post" action="{{route('staff.update',['staff' => $staff])}}">
        @csrf <!-- For security purpose-->
        @method('put')

        <div>
            <label>Name</label>
            <input type="text" name="name" placeholder="name" value="{{$staff->name}}" />
        </div>
        <div>
            <label>Qty</label>
            <input type="text" name="qty" placeholder="qty" value="{{$staff->qty}}"/>
        </div>
        <div>
            <label>Price</label>
            <input type="text" name="price" placeholder="price" value="{{$staff->price}}"/>
        </div>
        <div>
            <label>Description</label>
            <input type="text" name="description" placeholder="Description" value="{{$staff->description}}"/>
        </div>
        <div>
            <input type="submit" value="Update">
        </div>
    </form>
</body>

</html>
