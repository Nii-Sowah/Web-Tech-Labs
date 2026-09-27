<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HABIT SMASH! — Daily Habit Tracker</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bangers&family=Permanent+Marker&family=Kalam:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="halftone-overlay"></div>

<header class="comic-header">
    <h1 class="title-pow">HABIT<span class="title-smash">SMASH!</span></h1>
    <p class="subtitle">— crush your daily goals, one panel at a time —</p>
</header>

<main class="board">

    <section class="add-habit-panel comic-panel">
        <h2>NEW MISSION <span class="star">★</span></h2>
        <form id="add-habit-form">
            <div class="form-row">
                <input type="text" id="habit-name" placeholder="e.g. Meditate 10 min" maxlength="60" required>
                <select id="habit-icon">
                    <option value="⭐">⭐ Star</option>
                    <option value="💪">💪 Muscle</option>
                    <option value="📚">📚 Book</option>
                    <option value="💧">💧 Water</option>
                    <option value="🏃">🏃 Run</option>
                    <option value="🧘">🧘 Zen</option>
                    <option value="🎯">🎯 Target</option>
                    <option value="🛏️">🛏️ Sleep</option>
                    <option value="🥗">🥗 Food</option>
                    <option value="✍️">✍️ Write</option>
                </select>
                <select id="habit-color">
                    <option value="#ff2e63">Hero Red</option>
                    <option value="#08d9d6">Villain Teal</option>
                    <option value="#ffcc00">Sidekick Yellow</option>
                    <option value="#9d4edd">Mystic Purple</option>
                    <option value="#39ff14">Toxic Green</option>
                </select>
                <button type="submit" class="btn-pow">ADD!</button>
            </div>
        </form>
    </section>

    <section id="habit-list" class="habit-list">
        <!-- habit cards injected here by script.js -->
        <p class="loading-msg">Loading your missions...</p>
    </section>

</main>

<footer class="comic-footer">
    <p>KEEP GOING, HERO. TOMORROW NEEDS YOU TOO.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="script.js"></script>
</body>
</html>
