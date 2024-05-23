<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$username = $_SESSION['username'];

// Fetch workouts data using prepared statement
$sql_workouts = "SELECT * FROM workouts WHERE user_id=(SELECT id FROM users WHERE username=?) ORDER BY date DESC";
$stmt_workouts = $conn->prepare($sql_workouts);
$stmt_workouts->bind_param("s", $username);
$stmt_workouts->execute();
$result_workouts = $stmt_workouts->get_result();

$workouts = '';
if ($result_workouts->num_rows > 0) {
    while ($row = $result_workouts->fetch_assoc()) {
        $workouts .= "<tr>
            <td>{$row['date']}</td>
            <td>{$row['workout_name']}</td>
            <td>{$row['sets']}</td>
            <td>{$row['reps']}</td>
            <td>{$row['weight']}</td>
        </tr>";
    }
}

// Fetch nutrition data using prepared statement
$sql_nutrition = "SELECT * FROM nutrition WHERE user_id=(SELECT id FROM users WHERE username=?) ORDER BY date DESC";
$stmt_nutrition = $conn->prepare($sql_nutrition);
$stmt_nutrition->bind_param("s", $username);
$stmt_nutrition->execute();
$result_nutrition = $stmt_nutrition->get_result();

$nutrition = '';
if ($result_nutrition->num_rows > 0) {
    while ($row = $result_nutrition->fetch_assoc()) {
        $nutrition .= "<tr>
            <td>{$row['date']}</td>
            <td>{$row['food_name']}</td>
            <td>{$row['calories']}</td>
            <td>{$row['protein']}</td>
            <td>{$row['carbs']}</td>
            <td>{$row['fat']}</td>
        </tr>";
    }
}

$conn->close();

// Now include the view_progress.html template
$content = 'templates/view_progress.html';
include 'templates/base.html';


