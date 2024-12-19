<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">{{-- icon css --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"> {{-- my css --}}

</head>

<body>
    <div class="sidebar">
        <h2>fyp app</h2>
        <ul>


            <li><a href="#"><i class="ri-home-line"></i> Home</a></li>
            <li><a href="{{ route('game.rating') }}"><i class="ri-trophy-line"></i> Rating</a></li>
            <li><a href="{{ route('game.recommended') }}"><i class="ri-star-line"></i> Recommended</a></li>
            <li><a href="#"><i class="ri-arrow-up-line"></i> Update</a></li>
            <li><a href="{{ route('game_store.index') }}"><i class="ri-gamepad-line"></i> My Game</a></li>
            <li><a href="#"><i class="ri-settings-line"></i> Settings</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="nav-bar">
            @if (Route::has('login'))
                <nav class="flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-lg font-medium text-black">Dashboard</a>
                    @else
                        <a href="{{ route('player.login') }}" class="text-lg font-medium text-black">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('player.register') }}" class="text-lg font-medium text-black">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
        <h1>Home</h1>
        @auth('player')
            <section class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                <p>Welcome, <strong>{{ Auth::guard('player')->user()->PlayerName }}</strong>!</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </section>
        @else
            <p>Please <a href="{{ route('player.login') }}">log in</a> to see your details.</p>
        @endauth

        <div class="event">
            <div id="carousel" class="carousel">
                @if ($event->isEmpty())
                    <img class="carousel-image placeholder" src="https://via.placeholder.com/800x450" alt="No Event Available">
                @else
                    @foreach ($event as $eventItem)
                        <img class="carousel-image" src="{{ asset($eventItem->EventImageURL) }}" alt="{{ $eventItem->EventName }}" style="display: none;">
                    @endforeach
                @endif
            </div>
        </div>

        <div class="eventbtn">
            <button id="prev" class="carousel-button"><i class="ri-arrow-left-s-line"></i></button>
            <button id="next" class="carousel-button"><i class="ri-arrow-right-s-line"></i></button>
        </div>


        <div class="top-bar">
            <h2>New Releases Game</h2>
            <div class="pagination">
                @if ($game->onFirstPage())
                    <button disabled> <i class="ri-arrow-left-s-line"></i> </button>
                @else
                    <a href="{{ $game->previousPageUrl() }}"><button> <i class="ri-arrow-left-s-line"></i>
                        </button></a>
                @endif

                @if ($game->hasMorePages())
                    <a href="{{ $game->nextPageUrl() }}"><button><i class="ri-arrow-right-s-line"></i></button></a>
                @else
                    <button disabled> <i class="ri-arrow-right-s-line"></i> </button>
                @endif
            </div>
        </div>
        <div class="new-releases">
            @foreach ($game as $g)
                <div class="game-card">
                    <!-- Make GameReferenceImages clickable -->
                    @if (!empty($g->GameReferenceImages) && is_array($g->GameReferenceImages))
                        <a href="{{ route('game.detail', ['game' => $g]) }}">
                            <img class="reference-image" src="{{ asset($g->GameReferenceImages[0]) }}"
                                alt="Game Reference Image" />
                        </a>
                    @else
                        <a href="{{ route('game.detail', ['game' => $g]) }}">
                            <img src="https://via.placeholder.com/400x200" alt="Game Reference Image" />
                        </a>
                    @endif

                    <!-- 游戏详细信息 -->
                    <div class="game-details">
                        <!-- Make GameAvatar clickable -->
                        @if ($g->GameAvatar)
                            <a href="{{ route('game.detail', ['game' => $g]) }}">
                                <img class="game-avatar" src="{{ asset($g->GameAvatar) }}" alt="Game Avatar" />
                            </a>
                        @else
                            <a href="{{ route('game.detail', ['game' => $g]) }}">
                                <img src="https://via.placeholder.com/60x60" alt="Game Avatar" />
                            </a>
                        @endif

                        <div class="game-info">
                            <p class="game-name">{{ $g->GameName }}</p>
                            <div class="game-meta">
                                @forelse (json_decode($g->GameCategory, true) as $category)
                                    <span class="game-category">{{ $category }}</span>
                                @empty
                                    <span class="game-category">{{ $g->GameCategory }}</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



        <div class="top-bar">
            <h2>Top Score Games</h2>
            <div class="pagination">
                @if ($topScoreGames->onFirstPage())
                    <button disabled> <i class="ri-arrow-left-s-line"></i> </button>
                @else
                    <a href="{{ $topScoreGames->previousPageUrl() }}"><button> <i class="ri-arrow-left-s-line"></i>
                        </button></a>
                @endif

                @if ($topScoreGames->hasMorePages())
                    <a href="{{ $topScoreGames->nextPageUrl() }}"><button><i
                                class="ri-arrow-right-s-line"></i></button></a>
                @else
                    <button disabled><i class="ri-arrow-right-s-line"></i></button>
                @endif
            </div>
        </div>
        <div class="new-releases">
            @foreach ($topScoreGames as $g)
                <div class="game-card">
                    <!-- Make GameReferenceImages clickable -->
                    @if (!empty($g->GameReferenceImages) && is_array($g->GameReferenceImages))
                        <a href="{{ route('game.detail', ['game' => $g]) }}">
                            <img class="reference-image" src="{{ asset($g->GameReferenceImages[0]) }}"
                                alt="Game Reference Image" />
                        </a>
                    @else
                        <a href="{{ route('game.detail', ['game' => $g]) }}">
                            <img src="https://via.placeholder.com/400x200" alt="Game Reference Image" />
                        </a>
                    @endif

                    <!-- 游戏详细信息 -->
                    <div class="game-details">
                        <!-- Make GameAvatar clickable -->
                        @if ($g->GameAvatar)
                            <a href="{{ route('game.detail', ['game' => $g]) }}">
                                <img class="game-avatar" src="{{ asset($g->GameAvatar) }}" alt="Game Avatar" />
                            </a>
                        @else
                            <a href="{{ route('game.detail', ['game' => $g]) }}">
                                <img src="https://via.placeholder.com/60x60" alt="Game Avatar" />
                            </a>
                        @endif

                        <div class="game-info">
                            <p class="game-name">{{ $g->GameName }}</p>
                            <div class="game-meta">
                                @forelse (json_decode($g->GameCategory, true) as $category)
                                    <span class="game-category">{{ $category }}</span>
                                @empty
                                    <span class="game-category">{{ $g->GameCategory }}</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
    <script src="{{ asset('js/carousel.js') }}"></script>
</body>

</html>
