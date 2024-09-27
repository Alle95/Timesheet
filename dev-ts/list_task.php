<?php
$pageTitle = 'Task list';
$dsn = 'mysql:host=localhost;dbname = time registration';
$username = 'root';
$password = '';
$conn = new mysqli("localhost", "root", "", "time registration");
try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Connecgtion failed: " . $e->getMessage();
    exit;
}
$tasks = [];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT tasks.id AS task_id, tasks.title, tasks.status, tasks.due_date, clients.name 
        FROM tasks
        JOIN clients ON clients.id = tasks.client_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            'task_id' => $row['task_id'],
            'title' => $row['title'],
            'status' => $row['status'],
            'due_date' => $row['due_date'],
            'client' => $row['name']
        ];
    }
} else {
    echo '<div class="alert alert-danger" role="alert">No user found!</div>';
}
// echo '<pre>';
// print_r($tasks);
// echo '</pre>';
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>

<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="row mb-3">
                <div class="col-md-8">
                    <h2 class="mb-4">Task List</h2>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TITLE</th>
                                <th>CLIENT NAME</th>
                                <th>STATUS</th>
                                <th>DUE DATE</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $task['title']; ?></td>
                                    <td><?php echo $task['client']; ?></td>
                                    <td><?php echo $task['status']; ?></td>
                                    <td><?php echo $task['due_date']; ?></td>
                                    <td><button style="--bs-btn-padding-y: 0rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: 0rem;" type="button" class="btn no-outline" onclick="window.location.href='create_task.php?id=<?php echo $task['task_id']; ?>';">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
