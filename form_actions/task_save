<?php
$dsn = 'mysql:host=localhost;dbname = time registration';
$username = 'root';
$password = '';
try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Connecgtion failed: " . $e->getMessage();
    exit;
}

if (isset($_POST['submit'])) {
    $task_id = intval(isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $client  = isset($_POST['client_id']) ? $_POST['client_id'] : '';
    $description  = isset($_POST['description']) ? $_POST['description'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $due_date = isset($_POST['dueDate']) ? $_POST['dueDate'] : '';
    $conn = new mysqli("localhost", "root", "", "time registration");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if($task_id === 0) {
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, client_id, status, due_date) 
                                        VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $client, $status, $due_date);
        if ($stmt->execute()) {
            header('Location: ../create_task.php?message=success'); 
        } else {
            header('Location: ../create_task.php?message=error');
        }
    } else {
        $stmt = $conn->prepare("UPDATE tasks 
                                    SET title = ?, description = ?, client_id = ?, status = ?, due_date = ?
                                    WHERE id = $task_id");
        // var_dump($stmt);exit;
            $stmt->bind_param("sssss",  $title, $description, $client, $status, $due_date);
            if ($stmt->execute()) {
                header('Location: ../create_task.php?message=edit.success'); // Redirect to the form page
            } else {
                header('Location: ../create_task.php?message=error.edit');
            }
    }
    $stmt->close();
    $conn->close();
} elseif(isset($_POST['delete'])) {
    $task_id = intval(isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $conn = new mysqli("localhost", "root", "", "time registration");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM tasks WHERE id = $task_id";
    if ($conn->query($sql) === TRUE) {
        header('Location: ../create_users.php?message=del.success');
      } else {
        echo "Error deleting record: " . $conn->error;
      }
      $conn->close();
}
