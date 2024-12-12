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
        @if ($errors->any())
            <!-- List out errors if user makes any mistake -->
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
            <label for="GameDescription">GameDescription</label><br>
            <textarea name="GameDescription" id="GameDescription" rows="4" placeholder="Write your game description here..."></textarea>
        </div>

        <div>
            <label>Game Category</label><br>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Action" id="Action">
                <label for="Action">Action</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Role-Playing Game" id="RolePlayingGame">
                <label for="RolePlayingGame">Role-Playing Game</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Strategy" id="Strategy">
                <label for="Strategy">Strategy</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Sports & Racing" id="SportsRacing">
                <label for="SportsRacing">Sports & Racing</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Adventure" id="Adventure">
                <label for="Adventure">Adventure</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Casual & Puzzle Games" id="CasualPuzzleGames">
                <label for="CasualPuzzleGames">Casual & Puzzle Games</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Multiplayer Online" id="MultiplayerOnline">
                <label for="MultiplayerOnline">Multiplayer Online</label>
            </div>
            <div>
                <input type="checkbox" name="GameCategory[]" value="Experimental Game" id="ExperimentalGame">
                <label for="ExperimentalGame">Experimental Game</label>
            </div>
        </div>

 

        <div>
            <label for="GamePrice">GamePrice</label>
            <input type="text" name="GamePrice" id="GamePrice" placeholder="Enter Game Price" />
        </div>

        <div>
            <label for="GameAchievementsCount">GameAchievementsCount</label>
            <input type="text" name="GameAchievementsCount" id="GameAchievementsCount"
                placeholder="Enter Achievements Count" />
        </div>

        <!-- GameAvatar field -->
        <div>
            <label for="GameAvatar">GameAvatar</label>
            <input type="file" name="GameAvatar" id="GameAvatar" accept="image/*" onchange="previewImage(event)" />
        </div>

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
            <input type="submit" value="Save New Game">
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
