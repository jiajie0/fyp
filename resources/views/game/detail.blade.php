<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Details</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        /* Main */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
            display: flex;
        }

        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .btn:hover {}

        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* sidebar */

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        /* details-box */
        .details-box {
            display: flex;
            flex-direction: row;
            gap: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .image-section {
            flex: 4;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .image-section .main-image {
            width: 800px;
            height: 450px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .image-section .thumbnail-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .image-section .thumbnail-container img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #ddd;
            cursor: pointer;
        }

        .image-section .pagination {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            width: 100%;
            gap: 10px;
        }

        .image-section .pagination button {
            padding: 5px 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .image-section .pagination button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .details-section {
            flex: 2.5;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .info img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
        }

        .info h2 {
            margin: 0;
            font-size: 24px;
        }

        .game-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .game-category {
            padding: 5px 5px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            color: #555555;
            white-space: nowrap;
        }

        .details-section canvas {
            max-width: 100%;
        }

        .developer-name {
            color: #4124ff;
            font-weight: normal;
        }

        .add-to-store-section {

            border-radius: 8px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .add-to-store-btn {
            padding: 20px 40px;
            font-size: 24px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            min-width: 250px;
            margin-left: 20px
        }

        .add-to-store-section p {
            font-size: 16px;
            color: #555;
        }



        .add-to-store-section a:hover {
            text-decoration: underline;
        }

        /* game-description */
        .game-description {
            flex: 1;
            padding: 20px;
        }

        .game-description-box {
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 10px
        }

        .game-description-text {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 5;
            /* Show only 5 lines */
            line-height: 1.5;
            /* Adjust line height to fit 5 lines */
            max-height: 7.5em;
            /* Adjust based on your font size and line height */
        }

        .expanded {
            display: block;
            /* Show full text when expanded */
            -webkit-line-clamp: none;
            /* Remove line clamp */
            max-height: none;
            /* Remove height limit */
            overflow: visible;
            /* Allow full content to show */
        }

        .view-more-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .view-more-btn:hover {
            background-color: #0056b3;
        }

        /* General Box Styling */
        .player-rating-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .rating-section {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        /* Review Card */
        .review-card {
            width: 97%;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #f9f9f9;
        }

        .review-header {
            display: flex;
            align-items: center;
        }

        .review-header strong {
            font-size: 16px;
            color: #333;
            margin-right: 10px;
        }

        .player-level {
            font-size: 12px;
            color: gray;
        }

        .review-text {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        .review-date {
            font-size: 12px;
            color: #999;
        }

        .recommend-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20%;
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin-right: 10px;
        }

        .recommend-icon.positive {
            background-color: #007bff;
        }

        .recommend-icon.negative {
            background-color: #dc3545;
        }

        /* Rating Form */
        .rating-options {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .rating-options label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .rating-textarea {
            width: 1185px;
            margin-bottom: 15px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: none;
        }

        textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
        }

        /* Buttons */
        .btn {
            background-color: #f9f9f9;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #a71d2a;
        }

        .login-link {
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .rating-box {
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>fyp app</h2>
        <ul>
            <li><a href="{{ route('welcome') }}"><i class="ri-home-line"></i> Home</a></li>
            <li><a href="#"><i class="ri-trophy-line"></i> Rating</a></li>
            <li><a href="#"><i class="ri-star-line"></i> Recommended</a></li>
            <li><a href="#"><i class="ri-arrow-up-line"></i> Update</a></li>
            <li><a href="{{ route('game_store.index') }}"><i class="ri-gamepad-line"></i> My Game</a></li>
            <li><a href="#"><i class="ri-settings-line"></i> Settings</a></li>
        </ul>
    </div>

    <div class="main-container">
        <div class="details-box">
            <div class="image-section">
                <img src="{{ is_array($game->GameReferenceImages) && count($game->GameReferenceImages) > 0 ? asset($game->GameReferenceImages[0]) : 'https://via.placeholder.com/800x450' }}"
                    alt="Main Game Image" class="main-image" id="mainImage">

                <div class="thumbnail-container" id="thumbnailContainer">
                    @if (is_array($game->GameReferenceImages))
                        @foreach (array_slice($game->GameReferenceImages, 0, 4) as $index => $image)
                            <img src="{{ asset($image) }}" alt="Thumbnail {{ $index }}" class="thumbnail"
                                onclick="changeMainImage('{{ asset($image) }}')">
                        @endforeach
                    @endif
                </div>

                <div class="pagination">
                    <button id="prevPage" onclick="changePage(-1)" disabled><strong>
                            < </strong></button>
                    <button id="nextPage" onclick="changePage(1)"
                        {{ is_array($game->GameReferenceImages) && count($game->GameReferenceImages) > 4 ? '' : 'disabled' }}><strong>
                            > </strong></button>
                </div>
            </div>

            <div class="details-section">
                <div class="info">
                    <img src="{{ $game->GameAvatar ? asset($game->GameAvatar) : 'https://via.placeholder.com/100x100' }}"
                        alt="{{ $game->GameName }}">
                    <div>
                        <h2>{{ $game->GameName }}</h2>
                        <div class="developer-name">
                            <p>{{ $developerName }}</p>
                        </div>

                        <div class="game-meta">
                            @forelse (json_decode($game->GameCategory, true) as $category)
                                <span class="game-category">{{ $category }}</span>
                            @empty
                                <span class="game-category">{{ $game->GameCategory }}</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <canvas id="ratingChart" width="400" height="355"></canvas>

                @auth('player')
                    <section class="add-to-store-section">
                        @if ($isInGameStore)
                            <button class="add-to-store-btn">Already Added</button>
                        @else
                            <form action="{{ route('game.addToStore', $game->GameID) }}" method="POST">
                                @csrf
                                <button type="submit" class="add-to-store-btn">Add to My Game</button>
                            </form>
                        @endif
                    </section>
                @else
                    <p>Please <a href="{{ route('player.login') }}">log in</a> to add games to the store.</p>
                @endauth
            </div>
        </div>


        <div class="game-description-box">
            <strong>Game Description:</strong>
            <p id="gameDescription" class="game-description-text">
                {!! nl2br(e($game->GameDescription)) !!}
            </p>
            <button id="viewMoreBtn" class="view-more-btn">View More</button>
        </div>

        <div class="player-rating-box" id="rating-section">
            @auth('player')
                @if ($playerRating)
                    <section class="rating-section">
                        <h2>Your Review</h2>
                        <div class="review-card">
                            <div class="review-header">
                                @if ($playerRating->RatingMark)
                                    <span class="recommend-icon positive">
                                        <i class="ri-thumb-up-fill"></i>
                                    </span>
                                @else
                                    <span class="recommend-icon negative">
                                        <i class="ri-thumb-down-fill"></i>
                                    </span>
                                @endif
                                <div>
                                    <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>
                                    <div class="player-level">
                                        <i>player level {{ Auth::guard('player')->user()->PlayerLevel }}</i>
                                    </div>
                                </div>
                            </div>
                            <p class="review-text"><em>{{ $playerRating->RatingText }}</em></p>
                            <p class="review-date">Rated on
                                {{ \Carbon\Carbon::parse($playerRating->RatingTime)->format('Y-m-d H:i:s') }}</p>
                            <div class="review-actions">
                                <form action="{{ route('game.deleteRating', $playerRating->RatingID) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn delete-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    </section>
                @else
                    <section class="rating-section">
                        <h2>Rate This Game</h2>
                        <form action="{{ route('game.rate', $game->GameID) }}" method="POST">
                            @csrf
                            <div class="rating-options">
                                <label>
                                    <input type="radio" name="RatingMark" value="1" required>
                                    <span class="recommend-icon positive">
                                        <i class="ri-thumb-up-fill"></i>
                                    </span>
                                </label>
                                <label>
                                    <input type="radio" name="RatingMark" value="0">
                                    <span class="recommend-icon negative">
                                        <i class="ri-thumb-down-fill"></i>
                                    </span>
                                </label>
                            </div>
                            <div class="rating-textarea">
                                <label for="RatingText">Why?</label><br>
                                <textarea name="RatingText" id="RatingText" rows="4" placeholder="Write your reason here..."></textarea>
                            </div>
                            <button type="submit" class="btn submit-btn">Submit Rating</button>
                        </form>
                    </section>
                @endif
            @else
                <p><a href="{{ route('player.login') }}" class="login-link">Log in</a> to rate this game.</p>
            @endauth
        </div>

        <div class="rating-box" id="rating-section">
            <section class="rating-section">
                <h2>Player Reviews</h2>

                @if ($ratings->isEmpty())
                    <p>No reviews yet. Be the first to rate this game!</p>
                @else
                    @foreach ($ratings as $rating)
                        <div class="review-card">
                            <div class="review-header">


                                @if ($rating->RatingMark)
                                    <span class="recommend-icon positive">
                                        <i class="ri-thumb-up-fill"></i>
                                    </span>
                                @else
                                    <span class="recommend-icon negative">
                                        <i class="ri-thumb-down-fill"></i>
                                    </span>
                                @endif
                                <div>
                                    <strong>{{ $rating->player->PlayerName }}</strong>
                                    <div class="player-level">
                                        <i>player level {{ $rating->PlayerLevel }}</i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p><em>{{ $rating->RatingText }}</em></p>
                                <p class="review-date">Rated on
                                    @if ($rating->RatingTime)
                                        {{ \Carbon\Carbon::parse($rating->RatingTime)->format('Y-m-d H:i:s') }}
                                    @else
                                        No rating time available
                                    @endif
                                </p>
                                <p>Total Likes: {{ $rating->TotalLikeReceived }}</p>
                                @auth('player')
                                    <form action="{{ route('ratings.like', $rating->RatingID) }}" method="POST">
                                        @csrf
                                        @if ($rating->likes->where('PlayerID', Auth::guard('player')->user()->PlayerID)->isEmpty())
                                            <button type="submit" class="btn btn-link"
                                                style="color: gray; text-decoration: none;">
                                                <i class="ri-thumb-up-fill"></i> Like
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-link"
                                                style="color: blue; text-decoration: none;" disabled>
                                                <i class="ri-thumb-up-fill"></i> Liked
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <p><a href="{{ route('player.login') }}">Log in</a> to like reviews.</p>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                @endif

            </section>
        </div>



    </div>
    <script>
        // If $game->GameReferenceImages is null or empty, use an empty array for thumbnails
        const thumbnails = @json($game->GameReferenceImages ? array_map(fn($image) => asset($image), $game->GameReferenceImages) : []);

        const thumbnailsPerPage = 5;
        let currentPage = 0;

        function renderThumbnails() {
            const container = document.getElementById('thumbnailContainer');
            container.innerHTML = '';

            // Only render thumbnails if there are any in the array
            if (thumbnails.length > 0) {
                const start = currentPage * thumbnailsPerPage;
                const end = Math.min(start + thumbnailsPerPage, thumbnails.length);

                for (let i = start; i < end; i++) {
                    const img = document.createElement('img');
                    img.src = thumbnails[i];
                    img.alt = `Thumbnail ${i + 1}`;
                    img.className = 'thumbnail';
                    img.onclick = () => changeMainImage(thumbnails[i]);
                    container.appendChild(img);
                }
            } else {
                // If there are no thumbnails, you can add an appropriate message or leave it empty
                container.innerHTML = '<p>No thumbnails available.</p>';
            }

            updatePaginationButtons();
        }

        function updatePaginationButtons() {
            const prevButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');

            prevButton.disabled = currentPage === 0;
            nextButton.disabled = (currentPage + 1) * thumbnailsPerPage >= thumbnails.length;
        }

        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 0) {
                currentPage--;
                renderThumbnails();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            if ((currentPage + 1) * thumbnailsPerPage < thumbnails.length) {
                currentPage++;
                renderThumbnails();
            }
        });

        // Call renderThumbnails on page load
        renderThumbnails();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 数据从 Blade 文件传递到 JavaScript
        const levels = [1, 2, 3, 4, 5];
        const ratingMark1 = @json(array_map(fn($level) => $ratingStats["level_{$level}_mark_1"], range(1, 5)));
        const ratingMark0 = @json(array_map(fn($level) => $ratingStats["level_{$level}_mark_0"], range(1, 5)));

        // 创建柱状图
        const ctx = document.getElementById('ratingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: levels.map(level => `Player Lv ${level}`), // X轴标签
                datasets: [{
                        label: 'Recommend',
                        data: ratingMark1, // 数据1：RatingMark 1
                        backgroundColor: '#007bff',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 0,
                    },
                    {
                        label: 'Do Not Recommend',
                        data: ratingMark0, // 数据2：RatingMark 0
                        backgroundColor: '#dc3545',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 0,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: false, // 如果想显示堆叠柱状图可以设置为true
                        grid: {
                            display: false // 隐藏 X 轴的背景网格线
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // 根据数据范围调整步进
                            display: false // 隐藏 Y 轴的刻度数字
                        },
                        grid: {
                            display: false // 隐藏 Y 轴的背景网格线
                        }
                    }
                }
            }
        });
    </script>

    <script>
        document.getElementById('viewMoreBtn').addEventListener('click', function() {
            var descriptionText = document.getElementById('gameDescription');
            var viewMoreButton = document.getElementById('viewMoreBtn');

            // Toggle between adding/removing the 'expanded' class
            if (descriptionText.classList.contains('expanded')) {
                descriptionText.classList.remove('expanded'); // Collapse text
                viewMoreButton.textContent = 'View More'; // Change button text
            } else {
                descriptionText.classList.add('expanded'); // Expand text
                viewMoreButton.textContent = 'View Less'; // Change button text
            }
        });
    </script>




</body>

</html>
