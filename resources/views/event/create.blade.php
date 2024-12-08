<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a Event</title>
</head>

<body>
    <h1>Create a Event</h1>

    <div>
        @if ($errors->any())
            <!-- List out errors if user makes any mistake -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <form method="post" action="{{ route('event.store') }}" enctype="multipart/form-data">
        @csrf <!-- For security purposes -->
        @method('post')

        <input type="hidden" name="StaffID" value="{{ $staffID }}" />

        <div>
            <label for="EventName">EventName</label>
            <input type="text" name="EventName" id="EventName" placeholder="Enter Event Name" />
        </div>

        <!-- EventImageURL field -->
        <div>
            <label for="EventImageURL">EventImageURL</label>
            <input type="file" name="EventImageURL" id="EventImageURL" accept="image/*" onchange="previewImage(event)" />
        </div>

        <!-- Image Preview -->
        <div>
            <p>Image Preview:</p>
            <img id="imagePreview" src="" alt="Your Uploaded Image" style="max-width: 300px; display: none;" />
        </div>

        <div>
            <input type="submit" value="Save New Event">
        </div>
    </form>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
</body>

</html>
