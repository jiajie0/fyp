<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Details</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet"> {{-- icon css --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"> {{-- my css --}}
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

    <script id="thumbnailsData" type="application/json">
        {!! json_encode($game->GameReferenceImages ? array_map(fn($image) => asset($image), $game->GameReferenceImages) : []) !!}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script id="ratingMark1Data" type="application/json">
        {!! json_encode(array_map(fn($level) => $ratingStats["level_{$level}_mark_1"], range(1, 5))) !!}
    </script>

    <script id="ratingMark0Data" type="application/json">
        {!! json_encode(array_map(fn($level) => $ratingStats["level_{$level}_mark_0"], range(1, 5))) !!}
    </script>

    <script src="{{ asset('js/thumbnail.js') }}"></script>

    <script src="{{ asset('js/ratingChart.js') }}"></script>

    <script src="{{ asset('js/gameDescription.js') }}"></script>


</body>

</html>
