<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "cash_tracker"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $budget = $_POST['budget'];

    $stmt = $mysqli->prepare("INSERT INTO users (username, budget) VALUES (?, ?)");
    $stmt->bind_param("sd", $username, $budget);
    $stmt->execute();
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_expense'])) {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("INSERT INTO expenses (user_id, amount, description) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $user_id, $amount, $description);
    $stmt->execute();
}


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $mysqli->query("SELECT budget FROM users WHERE id = $user_id");
    $user = $result->fetch_assoc();

    $result = $mysqli->query("SELECT SUM(amount) AS total_expense FROM expenses WHERE user_id = $user_id");
    $expense = $result->fetch_assoc();
    $total_expense = $expense['total_expense'] ?? 0;

    if ($total_expense > $user['budget']) {
        $alert = "You have exceeded your budget!";
    }
}
?>