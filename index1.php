<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Bingo Royale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #6C5CE7;
            --primary-dark: #5B4CCE;
            --secondary: #00CEC9;
            --accent: #FD79A8;
            --gold: #FDCB6E;
            --bg-light: #F8F9FD;
            --bg-dark: #1A1A2E;
            --card-light: #FFFFFF;
            --card-dark: #16213E;
            --text-light: #2D3436;
            --text-dark: #F8F9FD;
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: var(--bg-light);
            color: var(--text-light);
            transition: all 0.3s ease;
        }

        body.dark {
            background: var(--bg-dark);
            color: var(--text-dark);
        }

        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* Animated gradient background */
        .bg-gradient-animated {
            background: linear-gradient(-45deg, #6C5CE7, #00CEC9, #FD79A8, #FDCB6E);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Bingo ball animation */
        @keyframes ballDrop {
            0% { transform: translateY(-100px) rotate(0deg); opacity: 0; }
            50% { transform: translateY(10px) rotate(180deg); opacity: 1; }
            70% { transform: translateY(-5px) rotate(270deg); }
            100% { transform: translateY(0) rotate(360deg); opacity: 1; }
        }

        @keyframes ballPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes celebrate {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25% { transform: scale(1.1) rotate(-5deg); }
            75% { transform: scale(1.1) rotate(5deg); }
        }

        @keyframes confetti {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-ball-drop {
            animation: ballDrop 0.6s ease-out forwards;
        }

        .animate-ball-pulse {
            animation: ballPulse 2s ease-in-out infinite;
        }

        .animate-celebrate {
            animation: celebrate 0.5s ease-in-out infinite;
        }

        .animate-slide-up {
            animation: slideUp 0.4s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Bingo Card Styles */
        .bingo-card {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 4px;
            max-width: 350px;
            margin: 0 auto;
        }

        .bingo-header {
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            padding: 8px;
            text-align: center;
            border-radius: 8px;
            color: white;
        }

        .bingo-cell {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 1.25rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            user-select: none;
        }

        body:not(.dark) .bingo-cell {
            background: #F0F0F5;
            color: var(--text-light);
        }

        body.dark .bingo-cell {
            background: #2D3A5C;
            color: var(--text-dark);
        }

        .bingo-cell.marked {
            background: var(--primary) !important;
            color: white !important;
            transform: scale(0.95);
        }

        .bingo-cell.marked::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 60%;
            border: 3px solid rgba(255,255,255,0.5);
            border-radius: 50%;
        }

        .bingo-cell.free-space {
            background: var(--gold) !important;
            color: #333 !important;
            font-size: 0.7rem;
        }

        .bingo-cell.winning {
            animation: celebrate 0.3s ease-in-out infinite;
            background: var(--secondary) !important;
        }

        /* Called numbers display */
        .called-numbers-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 4px;
            font-size: 0.75rem;
        }

        .called-number {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            font-size: 0.65rem;
            transition: all 0.3s ease;
        }

        body:not(.dark) .called-number {
            background: #E8E8EE;
            color: #999;
        }

        body.dark .called-number {
            background: #2D3A5C;
            color: #666;
        }

        .called-number.called {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        /* Current ball display */
        .current-ball {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Fredoka', sans-serif;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3), inset 0 -5px 20px rgba(0,0,0,0.2), inset 0 5px 20px rgba(255,255,255,0.3);
        }

        .current-ball .letter {
            font-size: 1.25rem;
            font-weight: 500;
            opacity: 0.9;
        }

        .current-ball .number {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        /* Buttons */
        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--secondary);
            color: white;
        }

        .btn-accent {
            background: var(--accent);
            color: white;
        }

        .btn-gold {
            background: linear-gradient(135deg, #FDCB6E, #E17055);
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        body.dark .btn-outline {
            border-color: var(--secondary);
            color: var(--secondary);
        }

        /* Cards */
        .game-card {
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        body:not(.dark) .game-card {
            background: var(--card-light);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        body.dark .game-card {
            background: var(--card-dark);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        /* Input styles */
        .input-field {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 16px;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            outline: none;
        }

        body:not(.dark) .input-field {
            background: #F0F0F5;
            color: var(--text-light);
        }

        body.dark .input-field {
            background: #2D3A5C;
            color: var(--text-dark);
        }

        .input-field:focus {
            border-color: var(--primary);
        }

        /* Room code display */
        .room-code {
            font-family: 'Fredoka', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.3em;
            color: var(--primary);
        }

        /* Confetti */
        .confetti-piece {
            position: fixed;
            width: 10px;
            height: 10px;
            top: -10px;
            animation: confetti 3s ease-out forwards;
        }

        /* Screen transitions */
        .screen {
            display: none;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 100px;
        }

        .screen.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 20px;
            animation: fadeIn 0.2s ease-out;
        }

        .modal-content {
            border-radius: 24px;
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        body:not(.dark) .modal-content {
            background: white;
        }

        body.dark .modal-content {
            background: var(--card-dark);
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 500;
            z-index: 200;
            animation: slideUp 0.3s ease-out;
        }

        /* Ball colors by letter */
        .ball-B { background: linear-gradient(135deg, #6C5CE7, #a29bfe); }
        .ball-I { background: linear-gradient(135deg, #00CEC9, #81ecec); }
        .ball-N { background: linear-gradient(135deg, #FD79A8, #fab1a0); }
        .ball-G { background: linear-gradient(135deg, #FDCB6E, #ffeaa7); }
        .ball-O { background: linear-gradient(135deg, #E17055, #ff7675); }

        /* Status indicator */
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.online { background: #00b894; }
        .status-dot.offline { background: #d63031; }
        .status-dot.waiting { background: #fdcb6e; animation: ballPulse 1s infinite; }

        /* Leaderboard */
        .leaderboard-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
        }

        body:not(.dark) .leaderboard-item {
            background: #F8F9FD;
        }

        body.dark .leaderboard-item {
            background: #2D3A5C;
        }

        .leaderboard-item.gold { background: linear-gradient(135deg, rgba(253,203,110,0.3), rgba(253,203,110,0.1)); }
        .leaderboard-item.silver { background: linear-gradient(135deg, rgba(178,190,195,0.3), rgba(178,190,195,0.1)); }
        .leaderboard-item.bronze { background: linear-gradient(135deg, rgba(225,112,85,0.3), rgba(225,112,85,0.1)); }

        /* Pattern selector */
        .pattern-option {
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .pattern-option.selected {
            border-color: var(--primary);
            background: rgba(108, 92, 231, 0.1);
        }

        .pattern-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 2px;
            width: 50px;
            margin: 0 auto;
        }

        .pattern-cell {
            aspect-ratio: 1;
            border-radius: 2px;
            background: #ddd;
        }

        body.dark .pattern-cell {
            background: #444;
        }

        .pattern-cell.active {
            background: var(--primary);
        }

        /* Telegram theme integration */
        .tg-theme {
            --primary: var(--tg-theme-button-color, #6C5CE7);
            --bg-light: var(--tg-theme-bg-color, #F8F9FD);
            --text-light: var(--tg-theme-text-color, #2D3436);
        }
    </style>
</head>
<body>
    <!-- Welcome Screen -->
    <div id="welcomeScreen" class="screen active">
        <div class="flex flex-col items-center justify-center min-h-screen py-8">
            <div class="text-center mb-8 animate-slide-up">
                <div class="text-6xl mb-4">🎱</div>
                <h1 class="font-display text-4xl font-bold bg-gradient-animated bg-clip-text text-transparent">
                    Bingo Royale
                </h1>
                <p class="mt-2 opacity-70">Play Bingo with friends remotely!</p>
            </div>

            <div class="w-full max-w-sm space-y-4" style="animation: slideUp 0.4s ease-out 0.1s both">
                <button onclick="showScreen('createRoomScreen')" class="btn btn-primary w-full text-lg">
                    <i class="fas fa-crown"></i> Host a Game
                </button>
                <button onclick="showScreen('joinRoomScreen')" class="btn btn-secondary w-full text-lg">
                    <i class="fas fa-sign-in-alt"></i> Join Game
                </button>
                <button onclick="showScreen('leaderboardScreen')" class="btn btn-outline w-full">
                    <i class="fas fa-trophy"></i> Leaderboard
                </button>
            </div>

            <div class="mt-8 text-center text-sm opacity-50" style="animation: slideUp 0.4s ease-out 0.2s both">
                <p>Status: <span id="connectionStatus" class="font-medium">Local Mode</span></p>
                <p class="mt-1">Player: <span id="playerName">Guest</span></p>
            </div>
        </div>
    </div>

    <!-- Create Room Screen -->
    <div id="createRoomScreen" class="screen">
        <div class="max-w-md mx-auto pt-8">
            <button onclick="showScreen('welcomeScreen')" class="mb-6 opacity-70 hover:opacity-100">
                <i class="fas fa-arrow-left"></i> Back
            </button>

            <div class="game-card animate-slide-up">
                <h2 class="font-display text-2xl font-bold mb-6 text-center">
                    <i class="fas fa-crown text-yellow-500"></i> Host Settings
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 opacity-70">Your Name</label>
                        <input type="text" id="hostNameInput" class="input-field" placeholder="Enter your name" maxlength="20">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 opacity-70">Game Title (Optional)</label>
                        <input type="text" id="gameTitleInput" class="input-field" placeholder="Friday Night Bingo!" maxlength="30">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-3 opacity-70">Winning Pattern</label>
                        <div class="grid grid-cols-4 gap-2" id="patternSelector">
                            <!-- Patterns added by JS -->
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 opacity-70">Auto-Call Speed</label>
                        <select id="autoCallSpeed" class="input-field">
                            <option value="0">Manual Only</option>
                            <option value="5">5 seconds</option>
                            <option value="10" selected>10 seconds</option>
                            <option value="15">15 seconds</option>
                            <option value="20">20 seconds</option>
                        </select>
                    </div>

                    <button onclick="createRoom()" class="btn btn-primary w-full mt-6">
                        <i class="fas fa-plus-circle"></i> Create Room
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Join Room Screen -->
    <div id="joinRoomScreen" class="screen">
        <div class="max-w-md mx-auto pt-8">
            <button onclick="showScreen('welcomeScreen')" class="mb-6 opacity-70 hover:opacity-100">
                <i class="fas fa-arrow-left"></i> Back
            </button>

            <div class="game-card animate-slide-up">
                <h2 class="font-display text-2xl font-bold mb-6 text-center">
                    <i class="fas fa-sign-in-alt text-teal-500"></i> Join Game
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 opacity-70">Your Name</label>
                        <input type="text" id="playerNameInput" class="input-field" placeholder="Enter your name" maxlength="20">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 opacity-70">Room Code</label>
                        <input type="text" id="roomCodeInput" class="input-field text-center text-2xl font-display tracking-widest"
                               placeholder="XXXX" maxlength="4" style="text-transform: uppercase;">
                    </div>

                    <button onclick="joinRoom()" class="btn btn-secondary w-full mt-6">
                        <i class="fas fa-play"></i> Join & Play
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Host Game Screen -->
    <div id="hostScreen" class="screen">
        <div class="max-w-lg mx-auto pt-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-display text-xl font-bold" id="hostGameTitle">Bingo Game</h2>
                    <p class="text-sm opacity-70">Room: <span id="hostRoomCode" class="room-code text-base">----</span></p>
                </div>
                <div class="text-right">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="status-dot online"></span>
                        <span id="playerCount">0</span> players
                    </div>
                </div>
            </div>

            <!-- Current Ball -->
            <div class="game-card mb-4 text-center">
                <p class="text-sm opacity-70 mb-3">Current Number</p>
                <div class="flex justify-center mb-4">
                    <div id="currentBall" class="current-ball ball-B animate-ball-pulse">
                        <span class="letter">-</span>
                        <span class="number">--</span>
                    </div>
                </div>
                <div class="flex gap-2 justify-center flex-wrap">
                    <button onclick="callNextNumber()" class="btn btn-primary" id="callBtn">
                        <i class="fas fa-bullhorn"></i> Call Number
                    </button>
                    <button onclick="toggleAutoCall()" class="btn btn-outline" id="autoCallBtn">
                        <i class="fas fa-play"></i> Auto
                    </button>
                </div>
                <p class="text-sm mt-3 opacity-50">
                    Called: <span id="calledCount">0</span>/75
                </p>
            </div>

            <!-- Called Numbers Grid -->
            <div class="game-card mb-4">
                <p class="text-sm font-medium mb-3 opacity-70">Called Numbers</p>
                <div id="calledNumbersGrid" class="called-numbers-grid">
                    <!-- Generated by JS -->
                </div>
            </div>

            <!-- Players List -->
            <div class="game-card mb-4">
                <p class="text-sm font-medium mb-3 opacity-70">Players</p>
                <div id="playersList" class="space-y-2">
                    <!-- Generated by JS -->
                </div>
            </div>

            <!-- Game Controls -->
            <div class="flex gap-2">
                <button onclick="resetGame()" class="btn btn-outline flex-1">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button onclick="endGame()" class="btn btn-accent flex-1">
                    <i class="fas fa-stop"></i> End Game
                </button>
            </div>
        </div>
    </div>

    <!-- Player Game Screen -->
    <div id="playerScreen" class="screen">
        <div class="max-w-lg mx-auto pt-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-display text-xl font-bold" id="playerGameTitle">Bingo Game</h2>
                    <p class="text-sm opacity-70">Room: <span id="playerRoomCode" class="font-bold">----</span></p>
                </div>
                <button onclick="claimBingo()" class="btn btn-gold animate-ball-pulse" id="bingoBtn">
                    <i class="fas fa-star"></i> BINGO!
                </button>
            </div>

            <!-- Last Called -->
            <div class="game-card mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-70">Last Called</p>
                        <p class="font-display text-3xl font-bold" id="lastCalledDisplay">--</p>
                    </div>
                    <div id="miniCurrentBall" class="current-ball ball-B" style="width: 60px; height: 60px;">
                        <span class="letter" style="font-size: 0.75rem;">-</span>
                        <span class="number" style="font-size: 1.5rem;">--</span>
                    </div>
                </div>
            </div>

            <!-- Bingo Card -->
            <div class="game-card mb-4">
                <div class="bingo-card" id="bingoCard">
                    <!-- Header Row -->
                    <div class="bingo-header ball-B">B</div>
                    <div class="bingo-header ball-I">I</div>
                    <div class="bingo-header ball-N">N</div>
                    <div class="bingo-header ball-G">G</div>
                    <div class="bingo-header ball-O">O</div>
                    <!-- Cells generated by JS -->
                </div>
                <div class="flex justify-center gap-4 mt-4 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="autoDaubCheck" checked class="w-4 h-4">
                        <span>Auto-Daub</span>
                    </label>
                </div>
            </div>

            <!-- Called Numbers Reference -->
            <div class="game-card">
                <details>
                    <summary class="cursor-pointer text-sm font-medium opacity-70">
                        View All Called Numbers (<span id="playerCalledCount">0</span>)
                    </summary>
                    <div id="playerCalledGrid" class="called-numbers-grid mt-3">
                        <!-- Generated by JS -->
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- Leaderboard Screen -->
    <div id="leaderboardScreen" class="screen">
        <div class="max-w-md mx-auto pt-8">
            <button onclick="showScreen('welcomeScreen')" class="mb-6 opacity-70 hover:opacity-100">
                <i class="fas fa-arrow-left"></i> Back
            </button>

            <div class="game-card animate-slide-up">
                <h2 class="font-display text-2xl font-bold mb-6 text-center">
                    <i class="fas fa-trophy text-yellow-500"></i> Leaderboard
                </h2>

                <div id="leaderboardList" class="space-y-2">
                    <!-- Generated by JS -->
                </div>

                <p class="text-center text-sm opacity-50 mt-6">
                    Top 10 players this week
                </p>
            </div>
        </div>
    </div>

    <!-- Winner Modal -->
    <div id="winnerModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="text-6xl mb-4">🎉</div>
            <h2 class="font-display text-3xl font-bold mb-2" id="winnerName">Player</h2>
            <p class="text-xl opacity-70 mb-6">wins this round!</p>
            <button onclick="closeWinnerModal()" class="btn btn-primary">
                <i class="fas fa-check"></i> Continue
            </button>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div id="confirmModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2 class="font-display text-xl font-bold mb-4" id="confirmTitle">Confirm</h2>
            <p class="opacity-70 mb-6" id="confirmMessage">Are you sure?</p>
            <div class="flex gap-3">
                <button onclick="closeConfirmModal(false)" class="btn btn-outline flex-1">Cancel</button>
                <button onclick="closeConfirmModal(true)" class="btn btn-primary flex-1" id="confirmBtn">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="toast" style="display: none;"></div>

    <script>
        // ============================================
        // DARK MODE DETECTION
        // ============================================
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.body.classList.add('dark');
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            document.body.classList.toggle('dark', event.matches);
        });

        // ============================================
        // TELEGRAM WEBAPP INTEGRATION
        // ============================================
        let tg = null;
        let tgUser = null;

        if (window.Telegram && window.Telegram.WebApp) {
            tg = window.Telegram.WebApp;
            tg.ready();
            tg.expand();

            if (tg.initDataUnsafe && tg.initDataUnsafe.user) {
                tgUser = tg.initDataUnsafe.user;
                document.getElementById('playerName').textContent = tgUser.first_name;
            }

            if (tg.colorScheme === 'dark') {
                document.body.classList.add('dark');
            }
        }

        // ============================================
        // GAME STATE
        // ============================================
        let gameState = {
            roomCode: null,
            isHost: false,
            hostName: '',
            playerName: '',
            gameTitle: 'Bingo Game',
            pattern: 'line',
            autoCallSpeed: 10,
            calledNumbers: [],
            availableNumbers: [],
            playerCard: [],
            markedCells: new Set(),
            players: {},
            autoCallInterval: null,
            isAutoCallActive: false
        };

        const BINGO_LETTERS = ['B', 'I', 'N', 'G', 'O'];
        const PATTERNS = {
            line: { name: 'Any Line', cells: null },
            diagonal: { name: 'Diagonal', cells: [[0,0],[1,1],[2,2],[3,3],[4,4], [0,4],[1,3],[2,2],[3,1],[4,0]] },
            corners: { name: '4 Corners', cells: [[0,0],[0,4],[4,0],[4,4]] },
            blackout: { name: 'Blackout', cells: 'all' },
            x: { name: 'X Pattern', cells: [[0,0],[0,4],[1,1],[1,3],[2,2],[3,1],[3,3],[4,0],[4,4]] },
            plus: { name: 'Plus', cells: [[0,2],[1,2],[2,0],[2,1],[2,2],[2,3],[2,4],[3,2],[4,2]] }
        };

        // ============================================
        // UTILITY FUNCTIONS
        // ============================================
        function generateRoomCode() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let code = '';
            for (let i = 0; i < 4; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return code;
        }

        function generateBingoCard() {
            const card = [];
            for (let col = 0; col < 5; col++) {
                const min = col * 15 + 1;
                const max = col * 15 + 15;
                const colNumbers = [];
                while (colNumbers.length < 5) {
                    const num = Math.floor(Math.random() * (max - min + 1)) + min;
                    if (!colNumbers.includes(num)) {
                        colNumbers.push(num);
                    }
                }
                card.push(colNumbers);
            }
            return card;
        }

        function getLetterForNumber(num) {
            if (num <= 15) return 'B';
            if (num <= 30) return 'I';
            if (num <= 45) return 'N';
            if (num <= 60) return 'G';
            return 'O';
        }

        function showToast(message, type = 'info') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.display = 'block';
            toast.style.background = type === 'error' ? '#d63031' :
                                     type === 'success' ? '#00b894' :
                                     'var(--primary)';
            toast.style.color = 'white';

            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        function showScreen(screenId) {
            document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
            document.getElementById(screenId).classList.add('active');
        }

        let confirmCallback = null;
        function showConfirm(title, message, callback) {
            document.getElementById('confirmTitle').textContent = title;
            document.getElementById('confirmMessage').textContent = message;
            document.getElementById('confirmModal').style.display = 'flex';
            confirmCallback = callback;
        }

        function closeConfirmModal(confirmed) {
            document.getElementById('confirmModal').style.display = 'none';
            if (confirmCallback) {
                confirmCallback(confirmed);
                confirmCallback = null;
            }
        }

        function closeWinnerModal() {
            document.getElementById('winnerModal').style.display = 'none';
        }

        function createConfetti() {
            const colors = ['#6C5CE7', '#00CEC9', '#FD79A8', '#FDCB6E', '#E17055'];
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti-piece';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDelay = Math.random() * 2 + 's';
                confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                document.body.appendChild(confetti);

                setTimeout(() => confetti.remove(), 5000);
            }
        }

        // ============================================
        // PATTERN SELECTOR
        // ============================================
        function initPatternSelector() {
            const container = document.getElementById('patternSelector');
            container.innerHTML = '';

            Object.entries(PATTERNS).forEach(([key, pattern]) => {
                const div = document.createElement('div');
                div.className = `pattern-option ${key === 'line' ? 'selected' : ''}`;
                div.onclick = () => selectPattern(key);
                div.dataset.pattern = key;

                const grid = document.createElement('div');
                grid.className = 'pattern-grid';

                for (let row = 0; row < 5; row++) {
                    for (let col = 0; col < 5; col++) {
                        const cell = document.createElement('div');
                        cell.className = 'pattern-cell';

                        if (key === 'line') {
                            if (row === 2) cell.classList.add('active');
                        } else if (key === 'blackout') {
                            cell.classList.add('active');
                        } else if (pattern.cells) {
                            if (pattern.cells.some(c => c[0] === row && c[1] === col)) {
                                cell.classList.add('active');
                            }
                        }
                        grid.appendChild(cell);
                    }
                }

                div.appendChild(grid);
                const label = document.createElement('p');
                label.className = 'text-xs mt-1 text-center';
                label.textContent = pattern.name;
                div.appendChild(label);

                container.appendChild(div);
            });
        }

        function selectPattern(patternKey) {
            gameState.pattern = patternKey;
            document.querySelectorAll('.pattern-option').forEach(el => {
                el.classList.toggle('selected', el.dataset.pattern === patternKey);
            });
        }

        // ============================================
        // CALLED NUMBERS GRID
        // ============================================
        function initCalledNumbersGrid(containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            for (let i = 1; i <= 75; i++) {
                const div = document.createElement('div');
                div.className = 'called-number';
                div.id = `${containerId}-${i}`;
                div.textContent = i;
                container.appendChild(div);
            }
        }

        function updateCalledNumbersGrid(containerId, calledNumbers) {
            for (let i = 1; i <= 75; i++) {
                const el = document.getElementById(`${containerId}-${i}`);
                if (el) {
                    el.classList.toggle('called', calledNumbers.includes(i));
                }
            }
        }

        // ============================================
        // BINGO CARD RENDERING
        // ============================================
        function renderBingoCard() {
            const cardEl = document.getElementById('bingoCard');
            const headers = cardEl.querySelectorAll('.bingo-header');
            cardEl.innerHTML = '';
            headers.forEach(h => cardEl.appendChild(h));

            for (let row = 0; row < 5; row++) {
                for (let col = 0; col < 5; col++) {
                    const cell = document.createElement('div');
                    cell.className = 'bingo-cell';
                    cell.dataset.row = row;
                    cell.dataset.col = col;

                    if (row === 2 && col === 2) {
                        cell.classList.add('free-space', 'marked');
                        cell.innerHTML = '<i class="fas fa-star"></i>';
                        gameState.markedCells.add('2-2');
                    } else {
                        const num = gameState.playerCard[col][row];
                        cell.textContent = num;
                        cell.dataset.number = num;
                        cell.onclick = () => toggleCell(row, col, num);
                    }

                    cardEl.appendChild(cell);
                }
            }
        }

        function toggleCell(row, col, num) {
            const key = `${row}-${col}`;
            const cell = document.querySelector(`.bingo-cell[data-row="${row}"][data-col="${col}"]`);

            if (gameState.markedCells.has(key)) {
                gameState.markedCells.delete(key);
                cell.classList.remove('marked');
            } else {
                gameState.markedCells.add(key);
                cell.classList.add('marked');
            }

            checkForBingo();
        }

        function autoDaub(number) {
            if (!document.getElementById('autoDaubCheck').checked) return;

            for (let col = 0; col < 5; col++) {
                for (let row = 0; row < 5; row++) {
                    if (gameState.playerCard[col][row] === number) {
                        const key = `${row}-${col}`;
                        if (!gameState.markedCells.has(key)) {
                            gameState.markedCells.add(key);
                            const cell = document.querySelector(`.bingo-cell[data-row="${row}"][data-col="${col}"]`);
                            if (cell) {
                                cell.classList.add('marked');
                                cell.style.animation = 'ballDrop 0.3s ease-out';
                            }
                        }
                    }
                }
            }

            checkForBingo();
        }

        function checkForBingo() {
            const marked = Array.from(gameState.markedCells).map(k => {
                const [r, c] = k.split('-').map(Number);
                return { row: r, col: c };
            });

            let hasBingo = false;

            // Check rows
            for (let row = 0; row < 5; row++) {
                if (marked.filter(m => m.row === row).length === 5) hasBingo = true;
            }

            // Check columns
            for (let col = 0; col < 5; col++) {
                if (marked.filter(m => m.col === col).length === 5) hasBingo = true;
            }

            // Check diagonals
            const diag1 = [[0,0],[1,1],[2,2],[3,3],[4,4]];
            const diag2 = [[0,4],[1,3],[2,2],[3,1],[4,0]];

            if (diag1.every(([r,c]) => gameState.markedCells.has(`${r}-${c}`))) hasBingo = true;
            if (diag2.every(([r,c]) => gameState.markedCells.has(`${r}-${c}`))) hasBingo = true;

            const bingoBtn = document.getElementById('bingoBtn');
            if (hasBingo) {
                bingoBtn.classList.add('animate-celebrate');
            } else {
                bingoBtn.classList.remove('animate-celebrate');
            }
        }

        // ============================================
        // ROOM MANAGEMENT
        // ============================================
        function createRoom() {
            const hostName = document.getElementById('hostNameInput').value.trim() ||
                            (tgUser ? tgUser.first_name : 'Host');
            const gameTitle = document.getElementById('gameTitleInput').value.trim() || 'Bingo Game';
            const autoSpeed = parseInt(document.getElementById('autoCallSpeed').value);

            gameState.roomCode = generateRoomCode();
            gameState.isHost = true;
            gameState.hostName = hostName;
            gameState.gameTitle = gameTitle;
            gameState.autoCallSpeed = autoSpeed;
            gameState.calledNumbers = [];
            gameState.availableNumbers = Array.from({length: 75}, (_, i) => i + 1);
            gameState.players = {};

            // Update UI
            document.getElementById('hostRoomCode').textContent = gameState.roomCode;
            document.getElementById('hostGameTitle').textContent = gameTitle;

            initCalledNumbersGrid('calledNumbersGrid');
            updatePlayersList();

            showScreen('hostScreen');
            showToast(`Room ${gameState.roomCode} created!`, 'success');
        }

        function joinRoom() {
            const playerName = document.getElementById('playerNameInput').value.trim() ||
                              (tgUser ? tgUser.first_name : 'Player');
            const roomCode = document.getElementById('roomCodeInput').value.trim().toUpperCase();

            if (roomCode.length !== 4) {
                showToast('Please enter a valid 4-character room code', 'error');
                return;
            }

            gameState.roomCode = roomCode;
            gameState.isHost = false;
            gameState.playerName = playerName;
            gameState.playerCard = generateBingoCard();
            gameState.markedCells = new Set();
            gameState.calledNumbers = [];

            // Update UI
            document.getElementById('playerRoomCode').textContent = roomCode;
            document.getElementById('playerGameTitle').textContent = 'Bingo Game';
            initCalledNumbersGrid('playerCalledGrid');
            renderBingoCard();

            showScreen('playerScreen');
            showToast(`Joined room ${roomCode}!`, 'success');
        }

        function updatePlayersList() {
            const list = document.getElementById('playersList');
            const players = Object.values(gameState.players);

            document.getElementById('playerCount').textContent = players.length;

            if (players.length === 0) {
                list.innerHTML = '<p class="text-sm opacity-50 text-center py-4">Waiting for players to join...</p>';
                return;
            }

            list.innerHTML = players.map(p => `
                <div class="flex items-center gap-3 p-2 rounded-lg" style="background: rgba(108,92,231,0.1)">
                    <span class="status-dot online"></span>
                    <span class="font-medium">${p.name}</span>
                </div>
            `).join('');
        }

        // ============================================
        // GAME CONTROLS (HOST)
        // ============================================
        function callNextNumber() {
            if (gameState.availableNumbers.length === 0) {
                showToast('All numbers have been called!', 'info');
                return;
            }

            const randomIndex = Math.floor(Math.random() * gameState.availableNumbers.length);
            const number = gameState.availableNumbers.splice(randomIndex, 1)[0];
            const letter = getLetterForNumber(number);

            gameState.calledNumbers.push(number);

            // Update current ball display
            const ball = document.getElementById('currentBall');
            ball.className = `current-ball ball-${letter} animate-ball-drop`;
            ball.querySelector('.letter').textContent = letter;
            ball.querySelector('.number').textContent = number;

            // Reset animation
            setTimeout(() => {
                ball.classList.remove('animate-ball-drop');
                ball.classList.add('animate-ball-pulse');
            }, 600);

            // Update called count
            document.getElementById('calledCount').textContent = gameState.calledNumbers.length;

            // Update grid
            updateCalledNumbersGrid('calledNumbersGrid', gameState.calledNumbers);
        }

        function toggleAutoCall() {
            const btn = document.getElementById('autoCallBtn');

            if (gameState.isAutoCallActive) {
                clearInterval(gameState.autoCallInterval);
                gameState.isAutoCallActive = false;
                btn.innerHTML = '<i class="fas fa-play"></i> Auto';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline');
            } else {
                if (gameState.autoCallSpeed === 0) {
                    showToast('Auto-call is disabled. Change speed in settings.', 'info');
                    return;
                }

                gameState.isAutoCallActive = true;
                btn.innerHTML = '<i class="fas fa-pause"></i> Stop';
                btn.classList.remove('btn-outline');
                btn.classList.add('btn-primary');

                gameState.autoCallInterval = setInterval(() => {
                    if (gameState.availableNumbers.length === 0) {
                        toggleAutoCall();
                        return;
                    }
                    callNextNumber();
                }, gameState.autoCallSpeed * 1000);
            }
        }

        function resetGame() {
            showConfirm('Reset Game', 'Are you sure you want to reset the game? All called numbers will be cleared.', (confirmed) => {
                if (confirmed) {
                    if (gameState.isAutoCallActive) {
                        toggleAutoCall();
                    }

                    gameState.calledNumbers = [];
                    gameState.availableNumbers = Array.from({length: 75}, (_, i) => i + 1);

                    // Reset UI
                    const ball = document.getElementById('currentBall');
                    ball.className = 'current-ball ball-B animate-ball-pulse';
                    ball.querySelector('.letter').textContent = '-';
                    ball.querySelector('.number').textContent = '--';

                    document.getElementById('calledCount').textContent = '0';
                    updateCalledNumbersGrid('calledNumbersGrid', []);

                    showToast('Game has been reset!', 'success');
                }
            });
        }

        function endGame() {
            showConfirm('End Game', 'Are you sure you want to end this game and return to the main menu?', (confirmed) => {
                if (confirmed) {
                    if (gameState.isAutoCallActive) {
                        toggleAutoCall();
                    }

                    gameState.roomCode = null;
                    gameState.isHost = false;
                    gameState.calledNumbers = [];
                    gameState.players = {};

                    showScreen('welcomeScreen');
                    showToast('Game ended', 'info');
                }
            });
        }

        // ============================================
        // PLAYER CONTROLS
        // ============================================
        function claimBingo() {
            // Check if player actually has bingo
            const marked = Array.from(gameState.markedCells).map(k => {
                const [r, c] = k.split('-').map(Number);
                return { row: r, col: c };
            });

            let hasBingo = false;

            // Check rows
            for (let row = 0; row < 5; row++) {
                if (marked.filter(m => m.row === row).length === 5) hasBingo = true;
            }

            // Check columns
            for (let col = 0; col < 5; col++) {
                if (marked.filter(m => m.col === col).length === 5) hasBingo = true;
            }

            // Check diagonals
            const diag1 = [[0,0],[1,1],[2,2],[3,3],[4,4]];
            const diag2 = [[0,4],[1,3],[2,2],[3,1],[4,0]];

            if (diag1.every(([r,c]) => gameState.markedCells.has(`${r}-${c}`))) hasBingo = true;
            if (diag2.every(([r,c]) => gameState.markedCells.has(`${r}-${c}`))) hasBingo = true;

            if (hasBingo) {
                document.getElementById('winnerName').textContent = gameState.playerName;
                document.getElementById('winnerModal').style.display = 'flex';
                createConfetti();
            } else {
                showToast('Not a valid BINGO yet! Keep playing!', 'error');
            }
        }

        function updatePlayerView() {
            const lastNum = gameState.calledNumbers[gameState.calledNumbers.length - 1];

            if (lastNum) {
                const letter = getLetterForNumber(lastNum);
                document.getElementById('lastCalledDisplay').textContent = `${letter}-${lastNum}`;

                const miniBall = document.getElementById('miniCurrentBall');
                miniBall.className = `current-ball ball-${letter}`;
                miniBall.querySelector('.letter').textContent = letter;
                miniBall.querySelector('.number').textContent = lastNum;

                // Auto-daub if enabled
                autoDaub(lastNum);
            }

            document.getElementById('playerCalledCount').textContent = gameState.calledNumbers.length;
            updateCalledNumbersGrid('playerCalledGrid', gameState.calledNumbers);
        }

        // ============================================
        // LEADERBOARD
        // ============================================
        function loadLeaderboard() {
            const list = document.getElementById('leaderboardList');

            // Demo leaderboard data
            const leaderboard = [
                { name: 'BingoMaster', wins: 42 },
                { name: 'LuckyPlayer', wins: 38 },
                { name: 'QuickDaub', wins: 35 },
                { name: 'WinnerWinner', wins: 28 },
                { name: 'BingoPro', wins: 25 },
                { name: 'CardShark', wins: 22 },
                { name: 'NumberNinja', wins: 19 },
                { name: 'DaubKing', wins: 15 },
                { name: 'BingoQueen', wins: 12 },
                { name: 'LuckyCharm', wins: 10 }
            ];

            list.innerHTML = leaderboard.map((player, index) => {
                let rankClass = '';
                let rankIcon = `<span class="w-6 text-center font-bold">${index + 1}</span>`;

                if (index === 0) {
                    rankClass = 'gold';
                    rankIcon = '<span class="w-6 text-center">🥇</span>';
                } else if (index === 1) {
                    rankClass = 'silver';
                    rankIcon = '<span class="w-6 text-center">🥈</span>';
                } else if (index === 2) {
                    rankClass = 'bronze';
                    rankIcon = '<span class="w-6 text-center">🥉</span>';
                }

                return `
                    <div class="leaderboard-item ${rankClass}">
                        ${rankIcon}
                        <span class="flex-1 ml-3 font-medium">${player.name}</span>
                        <span class="font-bold" style="color: var(--primary)">${player.wins} wins</span>
                    </div>
                `;
            }).join('');
        }

        // ============================================
        // DEMO MODE - Simulate number calls for player view
        // ============================================
        function startDemoMode() {
            // For demo purposes, simulate receiving called numbers
            setInterval(() => {
                if (!gameState.isHost && gameState.roomCode && Math.random() > 0.5) {
                    if (gameState.calledNumbers.length < 75) {
                        let newNum;
                        do {
                            newNum = Math.floor(Math.random() * 75) + 1;
                        } while (gameState.calledNumbers.includes(newNum));

                        gameState.calledNumbers.push(newNum);
                        updatePlayerView();
                    }
                }
            }, 3000);
        }

        // ============================================
        // INITIALIZATION
        // ============================================
        function init() {
            initPatternSelector();
            loadLeaderboard();
            startDemoMode();

            // Set Telegram user name if available
            if (tgUser) {
                document.getElementById('playerName').textContent = tgUser.first_name;
            }
        }

        // Run on load
        init();
    </script>
</body>
</html>