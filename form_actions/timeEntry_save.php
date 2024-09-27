<?php


$dsn = 'mysql:host=localhost;dbname=time registration';
$username = 'root';
$password = '';
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling

    // Fetch the task titles from the database
    $taskStmt = $pdo->query("SELECT id, title FROM tasks");
    $tasks = $taskStmt->fetchAll(PDO::FETCH_ASSOC); // Fetch tasks as an associative array
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if (isset($_POST['submit'])) {
    $task_id = isset($_POST['taskTitle']) ? $_POST['taskTitle'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $hours = isset($_POST['hours']) ? $_POST['hours'] : '00';
    $minutes = isset($_POST['minutes']) ? $_POST['minutes'] : '00';
    $approved = isset($_POST['approved']) ? $_POST['approved'] : ' ';
    // Combine hours and minutes into a TIME format
    $time = sprintf('%02d:%02d:00', $hours, $minutes);

    $conn = new mysqli("localhost", "root", "", "time registration");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO time_entries (task_id, date, time, description, user_id, approved) VALUES (?, ?, ?, ?, ?, 'pending')");

    $user_id = 1;

    $stmt->bind_param("isssi", $task_id, $date, $time, $description, $user_id);

    if ($stmt->execute()) {
        header('Location: ../list_entries.php?message=success');
    } else {
        header('Location: ../time_entry.php?message=error');
    }

    $stmt->close();
    $conn->close();
}
