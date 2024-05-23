<?php
session_start();
$content = 'templates/log_nutrition.html';
include 'templates/base.html';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $food = $_POST['food'];
    $date = $_POST['date'];
    $calories = $_POST['calories'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $fat = $_POST['fat'];

    // Get user ID from username
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Insert nutrition data
        $stmt = $conn->prepare("INSERT INTO nutrition (user_id, food_name, date, calories, protein, carbs, fat) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssddd", $user_id, $food, $date, $calories, $protein, $carbs, $fat);
        if ($stmt->execute()) {
            echo "Nutrition logged successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: User not found";
    }

    $stmt->close();
    $conn->close();
}
?>
