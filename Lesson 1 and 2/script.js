/* ==========================================================
   HABIT SMASH! — frontend logic (jQuery)
   ========================================================== */
$(function () {

    const $list = $('#habit-list');

    loadHabits();

    /* ---------- ADD HABIT ---------- */
    $('#add-habit-form').on('submit', function (e) {
        e.preventDefault();

        const name  = $('#habit-name').val().trim();
        const icon  = $('#habit-icon').val();
        const color = $('#habit-color').val();

        if (!name) return;

        $.post('api.php', { action: 'add', name: name, icon: icon, color: color })
            .done(function (res) {
                if (res.error) {
                    alert(res.error);
                    return;
                }
                $('#habit-name').val('');
                loadHabits();
            })
            .fail(function () {
                alert('Could not add habit — check your database connection.');
            });
    });

    /* ---------- DELETE HABIT ---------- */
    $list.on('click', '.delete-btn', function () {
        const $card = $(this).closest('.habit-card');
        const habitId = $card.data('id');

        if (!confirm('Delete this habit? This cannot be undone!')) return;

        $.post('api.php', { action: 'delete', habit_id: habitId })
            .done(function () {
                $card.fadeOut(200, function () { $(this).remove(); });
            });
    });

    /* ---------- TOGGLE DAY ---------- */
    $list.on('click', '.day-check', function () {
        const $cell    = $(this);
        const $card    = $cell.closest('.habit-card');
        const habitId  = $card.data('id');
        const date     = $cell.data('date');

        if ($cell.hasClass('locked')) return; // avoid double-click spam
        $cell.addClass('locked');

        $.post('api.php', { action: 'toggle', habit_id: habitId, date: date })
            .done(function (res) {
                if (res.error) { $cell.removeClass('locked'); return; }

                $cell.toggleClass('done', res.completed);
                $cell.addClass('pop');
                setTimeout(() => $cell.removeClass('pop'), 350);

                if (res.completed) showBurst($cell);

                updateStreakBadge($card, res.streak);
            })
            .always(function () {
                $cell.removeClass('locked');
            });
    });

    /* ---------- HELPERS ---------- */

    function loadHabits() {
        $.get('api.php', { action: 'list' })
            .done(function (habits) {
                renderHabits(habits);
            })
            .fail(function () {
                $list.html('<p class="empty-state">Could not reach the server. Check your PHP/MySQL setup!</p>');
            });
    }

    function renderHabits(habits) {
        $list.empty();

        if (!habits || habits.length === 0) {
            $list.html('<p class="empty-state">No missions yet — add your first habit above! 🦸</p>');
            return;
        }

        habits.forEach(function (habit) {
            $list.append(buildHabitCard(habit));
        });
    }

    function buildHabitCard(habit) {
        const $card = $('<div class="habit-card"></div>')
            .attr('data-id', habit.id)
            .css('--habit-color', habit.color);

        const $top = $('<div class="habit-card-top"></div>');

        const $nameWrap = $('<div class="habit-name-wrap"></div>');
        $nameWrap.append($('<span class="habit-icon"></span>').text(habit.icon));
        $nameWrap.append($('<span class="habit-name"></span>').text(habit.name));

        const $streak = buildStreakBadge(habit.streak);
        const $delete = $('<button class="delete-btn" title="Delete habit">✕</button>');

        const $rightSide = $('<div style="display:flex;align-items:center;gap:8px;"></div>')
            .append($streak)
            .append($delete);

        $top.append($nameWrap).append($rightSide);

        const $daysRow = $('<div class="days-row"></div>');
        habit.days.forEach(function (day) {
            const $dayCell = $('<div class="day-cell"></div>');
            if (day.isToday) $dayCell.addClass('today');

            $dayCell.append($('<span class="day-label"></span>').text(day.label));

            const $check = $('<div class="day-check"></div>')
                .attr('data-date', day.date)
                .toggleClass('done', day.completed)
                .css('--habit-color', habit.color);

            $dayCell.append($check);
            $daysRow.append($dayCell);
        });

        $card.append($top).append($daysRow);
        return $card;
    }

    function buildStreakBadge(streak) {
        const label = streak > 0 ? `🔥 ${streak} DAY${streak === 1 ? '' : 'S'}` : 'NO STREAK';
        return $('<span class="streak-badge"></span>')
            .addClass(streak === 0 ? 'zero' : '')
            .text(label);
    }

    function updateStreakBadge($card, streak) {
        const $badge = $card.find('.streak-badge');
        const label = streak > 0 ? `🔥 ${streak} DAY${streak === 1 ? '' : 'S'}` : 'NO STREAK';
        $badge.text(label).toggleClass('zero', streak === 0);
    }

    function showBurst($cell) {
        const words = ['POW!', 'BAM!', 'ZAP!', 'YES!', 'BOOM!'];
        const word = words[Math.floor(Math.random() * words.length)];

        const $burst = $('<span class="burst"></span>').text(word);
        const pos = $cell.position();

        $burst.css({
            left: pos.left - 10,
            top: pos.top - 20
        });

        $cell.closest('.habit-card').append($burst);
        setTimeout(() => $burst.remove(), 600);
    }

});
