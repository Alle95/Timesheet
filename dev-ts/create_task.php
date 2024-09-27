<?php
$pageTitleOptions = array("Create task", "Edit task");
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $pageTitle = $pageTitleOptions[1];
} else {
    $pageTitle =  $pageTitleOptions[0];
}
$status = array("Pending", "Accepted", "Completed");
?>

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
$task_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$task = [];
if ($task_id > 0) {
    $conn = new mysqli("localhost", "root", "", "time registration");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT tasks.title, tasks.description, tasks.client_id, tasks.status, tasks.due_date, clients.name
    FROM tasks
    JOIN clients ON clients.id = tasks.client_id
    WHERE tasks.id = $task_id
    LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $task = [
                'title' => $row['title'],
                'description' => $row['description'],
                'client' => $row['name'],
                'status' => $row['status'],
                'due_date' => $row['due_date']
            ];
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">No task found!</div>';
    }
    $conn->close();
// echo '<pre>';
// print_r($task);
// echo '</pre>';
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>

<body>
    <?php include("menu.php"); ?>
    <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="card shadow-lg mb-3" style="max-width: 750px;">
            <form class="row" form method="POST" action="form_actions/task_save.php">
                <input type="hidden" name="id" value="<?=$task_id?>">
                <div class="col-12 mt-2 mb-2">
                    <h2 class="text-center">
                        <?php
                        if (isset($_GET['id']) && $_GET['id'] > 0) {
                            echo "Edit";
                        } else {
                            echo "Create New";
                        }
                        ?>
                        Task</h2>
                        <?php
                    if (isset($_GET['message']) && $_GET['message'] === 'success') {
                        echo '<div class="alert alert-success" role="alert">Registration Successful!</div>';
                    } else if (isset($_GET['message']) && $_GET['message'] === 'email') {
                        echo '<div class="alert alert-danger" role="alert">This email has already been used!</div>';
                    }else if (isset($_GET['message']) && $_GET['message'] === 'del.success') {
                        echo '<div class="alert alert-success" role="alert">This user has been deleted!</div>';
                    }else if (isset($_GET['message']) && $_GET['message'] === 'error.edit') {
                        echo '<div class="alert alert-danger" role="alert">Something went wrong, please try again!</div>';
                    }else if (isset($_GET['message']) && $_GET['message'] === 'edit.success') {
                        echo '<div class="alert alert-success" role="alert">This user has been updated!</div>';
                    }
                    ?>
                </div>
                <div class="col-12 mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $task['title'] ?? '' ?>" required>
                </div>
                <div class="col-12 col-sm-6 mb-3">
                <?php
                $conn = new mysqli("localhost", "root", "", "time registration");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT id, name FROM clients";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<label class='form-label' for='client'>Client</label>";
                    echo "<select id='client' name='client_id' class='form-select' >";
                    echo '<option value="">' . ($task['client'] ?? 'Select Client') . '</option>';
                    while ($row = $result->fetch_assoc()) {
                        $client_id = htmlspecialchars($row['id']);
                        $client_name = htmlspecialchars($row['name']);
                        echo "<option value='" . $client_id . "'>" . $client_name . "</option>";
                    }
                    echo "</select>";
                } else {
                    echo "No clients found.";
                }
                $conn->close();
                ?>
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" >
                    <option value=""> <?= $task['status'] ?? 'Choose here' ?></option>
                        <?php
                        foreach ($status as $status) :
                        ?>
                            <option> <?= $status ?> </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="due_date" class="form-label">Due date</label>
                    <input type="date" class="form-control" name="dueDate" id="due_date" value="<?= $task['due_date'] ?? '' ?>" required>
                </div>
                <div class="col-md-12 col-sm-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="8" cols="60"><?= $task['description'] ?? '' ?></textarea>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-5">
                    <button class="btn btn-outline-dark" value="Submit" name="submit" type="submit">Save</button>
                </div>
                <?php
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                ?>
                    <div class="d-grid gap-2 col-6 mx-auto mt-5">
                        <button class="btn btn-outline-dark" value="delete" name="delete" type="delete">Delete</button>
                    </div>
                <?php
                }
                ?>
            </form>
            <footer class="my-5 pt-5 text-body-secondary text-center text-small">
                <p class="mb-1">&copy; 2024 Time entry </p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Privacy</a></li>
                    <li class="list-inline-item"><a href="#">Terms</a></li>
                    <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
            </footer>
        </div>
    </div>
</body>

</html>
