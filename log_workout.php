<?php
session_start();
$content = 'templates/log_workout.html';
include 'templates/base.html';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $workout = $_POST['workout'];
    $date = $_POST['date'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $weight = $_POST['weight'];

    // Get user ID from username
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Insert workout data
        $stmt = $conn->prepare("INSERT INTO workouts (user_id, workout_name, date, sets, reps, weight) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdd", $user_id, $workout, $date, $sets, $reps, $weight);
        if ($stmt->execute()) {
            echo "Workout logged successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: User not found";
    }

    $stmt->close();
    $conn->close();
}