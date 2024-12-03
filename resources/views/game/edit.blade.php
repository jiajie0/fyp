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
        @if($errors->any()) <!-- List out errors the user makes -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <form method="post" action="{{ route('game.update', ['game' => $game]) }}" enctype="multipart/form-data">
        @csrf <!-- For security purposes -->
        @method('put') <!-- Indicating this is a PUT request for updating data -->

        <div>
            <label for="DeveloperID">Developer ID</label>
            <input type="text" name="DeveloperID" id="DeveloperID" placeholder="Enter Developer ID" value="{{ $game->DeveloperID }}" />
        </div>

        <div>
            <label for="GameName">Game Name</label>
            <input type="text" name="GameName" id="GameName" placeholder="Enter Game Name" value="{{ $game->GameName }}" />
        </div>

        <div>
            <label for="GameDescription">Game Description</label>
            <input type="text" name="GameDescription" id="GameDescription" placeholder="Enter Game Description" value="{{ $game->GameDescription }}" />
        </div>

        <div>
            <label for="GameCategory">Game Category</label>
            <input type="text" name="GameCategory" id="GameCategory" placeholder="Enter Game Category" value="{{ $game->GameCategory }}" />
        </div>

        <div>
            <label for="GamePrice">Game Price</label>
            <input type="text" name="GamePrice" id="GamePrice" placeholder="Enter Game Price" value="{{ $game->GamePrice }}" />
        </div>

        <div>
            <label for="GameAchievementsCount">Game Achievements Count</label>
            <input type="text" name="GameAchievementsCount" id="GameAchievementsCount" placeholder="Enter Achievements Count" value="{{ $game->GameAchievementsCount }}" />
        </div>

        <!-- GameAvatar upload field -->
        <div>
            <label for="GameAvatar">Game Avatar</label>
            <input type="file" name="GameAvatar" id="GameAvatar" accept="image/*" onchange="previewImage(event)" />
        </div>

        <!-- Display current avatar if exists -->
        @if($game->GameAvatar)
            <div>
                <p>Current Avatar:</p>
                <img src="{{ asset($game->GameAvatar) }}" alt="{{ $game->GameName }}" style="max-width: 300px;">
            </div>
        @endif

        <!-- Image Preview -->
        <div>
            <p>Image Preview:</p>
            <img id="imagePreview" src="" alt="Your Uploaded Image" style="max-width: 300px; display: none;" />
        </div>

        <div>
            <label for="GameReferenceImages">Game Reference Images (up to 10)</label>
            <input type="file" name="GameReferenceImages[]" id="GameReferenceImages" accept="image/*" multiple
                onchange="previewMultipleImages(event)" />
        </div>

        <div id="referenceImagesPreview" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <!-- Images will be appended here -->
        </div>

        <div>
            <input type="submit" value="Update Game">
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
