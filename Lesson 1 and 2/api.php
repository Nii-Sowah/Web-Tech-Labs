<?php
/**
 * ==========================================================
 *  HABIT TRACKER — API
 *  All requests go through here as JSON.
 *  Actions: list | add | delete | toggle
 * ==========================================================
 */
header('Content-Type: application/json');
require_once 'config.php';

$pdo    = get_db();
$action = $_REQUEST['action'] ?? '';

switch ($action) {

    case 'list':
        echo json_encode(get_all_habits($pdo));
        break;

    case 'add':
        $name  = trim($_POST['name'] ?? '');
        $icon  = trim($_POST['icon'] ?? '⭐');
        $color = trim($_POST['color'] ?? '#ff2e63');

        if ($name === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Habit name is required.']);
            break;
        }

        $maxOrder = (int)$pdo->query('SELECT COALESCE(MAX(sort_order),0) FROM habits')->fetchColumn();
        $stmt = $pdo->prepare('INSERT INTO habits (name, icon, color, sort_order) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $icon, $color, $maxOrder + 1]);

        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        break;

    case 'delete':
        $id = (int)($_POST['habit_id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid habit id.']);
            break;
        }
        $stmt = $pdo->prepare('DELETE FROM habits WHERE id = ?');
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        break;

    case 'toggle':
        $id   = (int)($_POST['habit_id'] ?? 0);
        $date = $_POST['date'] ?? date('Y-m-d');

        if ($id <= 0 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid parameters.']);
            break;
        }

        // Check if a log already exists for that day
        $stmt = $pdo->prepare('SELECT id, completed FROM habit_logs WHERE habit_id = ? AND log_date = ?');
        $stmt->execute([$id, $date]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Toggle it off (delete) since it existed and was completed
            $del = $pdo->prepare('DELETE FROM habit_logs WHERE id = ?');
            $del->execute([$existing['id']]);
            $nowCompleted = false;
        } else {
            $ins = $pdo->prepare('INSERT INTO habit_logs (habit_id, log_date, completed) VALUES (?, ?, 1)');
            $ins->execute([$id, $date]);
            $nowCompleted = true;
        }

        echo json_encode([
            'success'   => true,
            'completed' => $nowCompleted,
            'streak'    => calculate_streak($pdo, $id),
        ]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action.']);
}

/**
 * Fetch all habits with their last 7 days of logs + current streak.
 */
function get_all_habits(PDO $pdo): array {
    $habits = $pdo->query('SELECT * FROM habits ORDER BY sort_order ASC, id ASC')->fetchAll();

    $days = [];
    for ($i = 6; $i >= 0; $i--) {
        $days[] = date('Y-m-d', strtotime("-$i day"));
    }

    foreach ($habits as &$habit) {
        $stmt = $pdo->prepare(
            'SELECT log_date FROM habit_logs WHERE habit_id = ? AND log_date IN (' .
            implode(',', array_fill(0, count($days), '?')) . ')'
        );
        $stmt->execute(array_merge([$habit['id']], $days));
        $completedDates = array_column($stmt->fetchAll(), 'log_date');

        $habit['days'] = array_map(function ($d) use ($completedDates) {
            return [
                'date'      => $d,
                'label'     => date('D', strtotime($d)),
                'completed' => in_array($d, $completedDates),
                'isToday'   => $d === date('Y-m-d'),
            ];
        }, $days);

        $habit['streak'] = calculate_streak($pdo, $habit['id']);
    }

    return $habits;
}

/**
 * Count consecutive completed days ending today (or yesterday, so
 * a streak isn't broken just because today hasn't been checked yet).
 */
function calculate_streak(PDO $pdo, int $habitId): int {
    $stmt = $pdo->prepare('SELECT log_date FROM habit_logs WHERE habit_id = ? AND completed = 1 ORDER BY log_date DESC');
    $stmt->execute([$habitId]);
    $dates = array_column($stmt->fetchAll(), 'log_date');
    $dateSet = array_flip($dates);

    $streak = 0;
    $cursor = new DateTime('today');

    // If today isn't logged yet, start checking from yesterday instead
    if (!isset($dateSet[$cursor->format('Y-m-d')])) {
        $cursor->modify('-1 day');
    }

    while (isset($dateSet[$cursor->format('Y-m-d')])) {
        $streak++;
        $cursor->modify('-1 day');
    }

    return $streak;
}
