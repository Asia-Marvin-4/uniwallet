<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "cash_tracker"); // Update with your database credentials

// User registration and budget setting
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $budget = $_POST['budget'];

    $stmt = $mysqli->prepare("INSERT INTO users (username, budget) VALUES (?, ?)");
    $stmt->bind_param("sd", $username, $budget);
    $stmt->execute();
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;
}

// Add expense
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_expense'])) {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("INSERT INTO expenses (user_id, amount, description) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $user_id, $amount, $description);
    $stmt->execute();
}

// Fetch expenses and budget
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $mysqli->query("SELECT budget FROM users WHERE id = $user_id");
    $user = $result->fetch_assoc();

    $result = $mysqli->query("SELECT SUM(amount) AS total_expense FROM expenses WHERE user_id = $user_id");
    $expense = $result->fetch_assoc();
    $total_expense = $expense['total_expense'] ?? 0;

    // Alert if over budget
    if ($total_expense > $user['budget']) {
        $alert = "You have exceeded your budget!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Tracker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Cash Tracker</h2>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="budget">Monthly Budget:</label>
                <input type="number" step="0.01" class="form-control" name="budget" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
    <?php else: ?>
        <h4>Welcome, <?php echo $_SESSION['username']; ?></h4>
        <h5>Your Budget: $<?php echo number_format($user['budget'], 2); ?></h5>
        <h5>Total Expenses: $<?php echo number_format($total_expense, 2); ?></h5>
        <?php if (isset($alert)): ?>
            <div class="alert alert-danger"><?php echo $alert; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="amount">Expense Amount:</label>
                <input type="number" step="0.01" class="form-control" name="amount" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" required>
            </div>
            <button type="submit" name="add_expense" class="btn btn-success">Add Expense</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>