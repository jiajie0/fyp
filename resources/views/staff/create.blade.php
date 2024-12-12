<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Details</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

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

        .main-container {
            flex: 1;
            padding: 20px;

        }

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
            width: 80px;
            height: 80px;
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

        .info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .info img {
            max-width: 100px;
            border-radius: 10px;
        }

        .info h2 {
            margin: 0;
            font-size: 24px;
        }

        .details-section {
            flex: 2.5;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .details-section .info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .details-section .info img {
            max-width: 100px;
            border-radius: 10px;
        }

        .details-section .info h2 {
            margin: 0;
        }

        .details-section canvas {
            max-width: 100%;
        }

        .game-meta {
            display: flex;
            /* Make sure categories are in one row */
            gap: 10px;
            /* Space between categories */
            flex-wrap: wrap;
            /* Allow wrapping if needed */
        }

        .game-category {
            padding: 5px 5px;
            background-color: #fff;
            /* White background */
            border: 1px solid #ccc;
            /* Gray border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 12px;
            color: #555555;
            white-space: nowrap;
            /* Prevent text from wrapping */
        }

        .developer-name {
            color: #4124ff;
            font-weight: normal;
        }

        .game-description-box {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
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
                <img src="{{ asset($game->GameReferenceImages[0]) }}" alt="Main Game Image" class="main-image"
                    id="mainImage">

                <div class="thumbnail-container" id="thumbnailContainer">
                    @foreach (array_slice($game->GameReferenceImages, 0, 4) as $index => $image)
                        <img src="{{ asset($image) }}" alt="Thumbnail {{ $index }}" class="thumbnail"
                            onclick="changeMainImage('{{ asset($image) }}')">
                    @endforeach
                </div>

                <div class="pagination">
                    <button id="prevPage" onclick="changePage(-1)" disabled><strong>
                            << /strong></button>
                    <button id="nextPage" onclick="changePage(1)"
                        {{ count($game->GameReferenceImages) <= 4 ? 'disabled' : '' }}><strong>></strong></button>
                </div>
            </div>

            <div class="details-section">
                <div class="info">
                    <img src="{{ asset($game->GameAvatar) }}" alt="{{ $game->GameName }}">
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
            </div>
        </div>
    </div>

    <div>

        @auth('player')
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
                <p>Your ID: <strong>{{ Auth::guard('player')->user()->PlayerScore }}</strong></p>
            </section>
        @else
            <p>Please <a href="{{ route('player.login') }}">log in</a> to see your details.</p>
        @endauth

        @if ($errors->any())
            <!-- List out errors the user makes -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div>
            <p><strong>Developer Name:</strong> {{ $developerName }}</p>
            <p><strong>Game Name:</strong> {{ $game->GameName }}</p>
            <div class="main-container">
                <p><strong>Game Description:</strong> {{ $game->GameDescription }}</p>
            </div>

            <strong>Game Category:</strong>
            @forelse (json_decode($game->GameCategory, true) as $category)
                <span class="game-category">{{ $category }}</span>
            @empty
                <span class="game-category">{{ $game->GameCategory }}</span>
            @endforelse

            <p><strong>Game Price:</strong> {{ $game->GamePrice }}</p>
            <p><strong>Achievements Count:</strong> {{ $game->GameAchievementsCount }}</p>


            @auth('player')
                <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                    <form action="{{ route('game.addToStore', $game->GameID) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Game Store</button>
                    </form>
                </section>
            @else
                <p>Please <a href="{{ route('player.login') }}">log in</a> to add games to the store.</p>
            @endauth

            @auth('player')
                @if ($playerRating)
                    <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                        <h2>Your Review</h2>
                        <div class="review mb-4 p-3 border rounded">
                            <p>
                                <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>
                                @if ($playerRating->RatingMark)
                                    <span style="color: green;">Recommended</span>
                                @else
                                    <span style="color: red;">Not Recommended</span>
                                @endif
                            </p>
                            <p><em>{{ $playerRating->RatingText }}</em></p>
                            <p class="text-muted">Rated on
                                {{ \Carbon\Carbon::parse($playerRating->RatingTime)->format('Y-m-d H:i:s') }}</p>
                            <div>
                                <form action="{{ route('game.deleteRating', $playerRating->RatingID) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </section>
                @else
                    <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                        <h2>Rate This Game</h2>
                        <form action="{{ route('game.rate', $game->GameID) }}" method="POST">
                            @csrf
                            <div>
                                <label>
                                    <input type="radio" name="RatingMark" value="1" required>
                                    Recommend
                                </label>
                                <label>
                                    <input type="radio" name="RatingMark" value="0">
                                    Do Not Recommend
                                </label>
                            </div>
                            <div>
                                <label for="RatingText">Why?</label><br>
                                <textarea name="RatingText" id="RatingText" rows="4" placeholder="Write your reason here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                        </form>
                    </section>
                @endif
            @else
                <p><a href="{{ route('player.login') }}">Log in</a> to rate this game.</p>
            @endauth

            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <h2>Player Reviews</h2>
                @if ($ratings->isEmpty())
                    <p>No reviews yet. Be the first to rate this game!</p>
                @else
                    @foreach ($ratings as $rating)
                        <div class="review mb-4 p-3 border rounded">
                            <p>
                                <strong>{{ $rating->player->PlayerName }}</strong>
                                @if ($rating->RatingMark)
                                    <span style="color: green;">Recommended</span>
                                @else
                                    <span style="color: red;">Not Recommended</span>
                                @endif
                            </p>
                            <p><em>{{ $rating->RatingText }}</em></p>
                            <p class="text-muted">Rated on
                                {{ \Carbon\Carbon::parse($rating->RatingTime)->format('Y-m-d H:i:s') }}</p>
                            <p>Total Likes: {{ $rating->TotalLikeReceived }}</p>
                            @auth('player')
                                <form action="{{ route('ratings.like', $rating->RatingID) }}" method="POST">
                                    @csrf
                                    @if ($rating->likes->where('PlayerID', Auth::guard('player')->user()->PlayerID)->isEmpty())
                                        <button type="submit" class="btn btn-primary">Like</button>
                                    @else
                                        <button type="button" class="btn btn-secondary" disabled>Liked</button>
                                    @endif
                                </form>
                            @else
                                <p><a href="{{ route('player.login') }}">Log in</a> to like reviews.</p>
                            @endauth
                        </div>
                    @endforeach
                @endif
            </section>
        </div>
    </div>
    </div>


    <script>
        const thumbnails = @json(array_map(fn($image) => asset($image), $game->GameReferenceImages));

        const thumbnailsPerPage = 5;
        let currentPage = 0;

        function renderThumbnails() {
            const container = document.getElementById('thumbnailContainer');
            container.innerHTML = '';

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
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 0,
                    },
                    {
                        label: 'Do Not Recommend',
                        data: ratingMark0, // 数据2：RatingMark 0
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
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
                            stepSize: 1 // 根据数据范围调整步进
                        },
                        grid: {
                            display: false // 隐藏 Y 轴的背景网格线
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
