<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Event</title>
</head>

<body>
    <h1>Edit a Event</h1>

    <div>
        @if($errors->any()) <!-- List out errors the user makes -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <form method="post" action="{{ route('event.update', ['event' => $event]) }}" enctype="multipart/form-data">
        @csrf <!-- For security purposes -->
        @method('put') <!-- Indicating this is a PUT request for updating data -->

        <input type="hidden" name="StaffID" value="{{ $staffID }}" />
        <div>
            <label for="EventName">Event Name</label>
            <input type="text" name="EventName" id="EventName" placeholder="Enter Event Name" value="{{ $event->EventName }}" />
        </div>

        <!-- EventImageURL upload field -->
        <div>
            <label for="EventImageURL">Event Image</label>
            <input type="file" name="EventImageURL" id="EventImageURL" accept="image/*" onchange="previewImage(event)" />
        </div>

        <!-- Display current EventImageURL if exists -->
        @if($event->EventImageURL)
            <div>
                <p>Current Image:</p>
                <img src="{{ asset($event->EventImageURL) }}" alt="{{ $event->EventName }}" style="max-width: 300px;">
            </div>
        @endif

        <!-- Image Preview -->
        <div>
            <p>Image Preview:</p>
            <img id="imagePreview" src="" alt="Your Uploaded Image" style="max-width: 300px; display: none;" />
        </div>

        <div>
            <label for="EventReferenceImages">Event Reference Images (up to 10)</label>
            <input type="file" name="EventReferenceImages[]" id="EventReferenceImages" accept="image/*" multiple
                onchange="previewMultipleImages(event)" />
        </div>

        <div id="referenceImagesPreview" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <!-- Images will be appended here -->
        </div>

        <div>
            <input type="submit" value="Update Event">
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

        function previewMultipleImages(event) {
            const input = event.target;
            const previewContainer = document.getElementById('referenceImagesPreview');

            // Clear any existing images
            previewContainer.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.alt = 'Reference Image';
                        img.style.margin = '5px';
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</body>

</html>
