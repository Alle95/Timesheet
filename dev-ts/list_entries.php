<?php 
$dsn = 'mysql:host=localhost;dbname=time registration';
$username = 'root';
$password = '';
$conn = new mysqli("localhost", $username, $password, "time registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    $query = 'SELECT time_entries.id, users.email, time_entries.date, tasks.title AS task_title, time_entries.time, time_entries.updated_at, time_entries.approved
              FROM time_entries
              INNER JOIN users ON time_entries.user_id = users.id
              INNER JOIN tasks ON time_entries.task_id = tasks.id';

    if (isset($_GET['filter_title']) && $_GET['filter_title'] !== '') {
        $query .= ' WHERE tasks.title LIKE :filter_title';
    }

    $query .= ' ORDER BY time_entries.date DESC'; 

    $stmt = $pdo->prepare($query);

    if (isset($_GET['filter_title']) && $_GET['filter_title'] !== '') {
        $stmt->bindValue(':filter_title', '%' . $_GET['filter_title'] . '%');
    }

    $stmt->execute();
    $timeEntry = $stmt->fetchAll(PDO::FETCH_ASSOC);

} 
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $pageTitle = "List time entries"; include("head.php"); ?>

<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="row mb-3">
                <div class="col-md-7">
                <form class="d-flex" method="GET">
    <input type="text" name="filter_title" placeholder="Task Title" class="form-control" value="<?php echo isset($_GET['filter_title']) ? $_GET['filter_title'] : ''; ?>">
    <button class="btn btn-outline-dark" type="submit">Search</button>
</form>
                </div>
            </div>

            <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
                <div class="alert alert-success" role="alert">Registration Successful!</div>
            <?php endif; ?>
            <br>
                <div class="col-md-4">
             <h2 class="mb-4">Time Entries List</h2>
                </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="input-group flex-nowrap">
                        <div class="col-md-3">
                                    <label>Status:</label>
                        </div>
                        <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" id="hours" name="hours" required>
                                        <option></option>
                                        <option value="Pending">Pending</option>
                                        <option value="Yes">Approved</option>
                                        <option value="No">Denied</option>
                                    </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group flex-nowrap">
                        <div class="col-md-3">
                                    <label>Date:</label>
                        </div>
                        <div class="col-md-6">
                        <input style="float:right" id="date" name="date"  class="form-control" type="date" placeholder="add date" required>
                    </div>
                        </div>
                    
                </div>
                <div class="col-md-6">
                <a style="float:right"  href="time_entry.php<?php echo (isset($_GET['role']) && $_GET['role'] === "Admin") ? '?role=Admin' : ''; ?>" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
</svg></a>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <?php if (isset($_GET['role']) && $_GET['role'] === "Admin"): ?>
                            <th>USERNAME</th>
                        <?php endif; ?>
                        <th>DATE</th>
                        <th>TASK TITLE</th>
                        <th>ALLOCATED TIME</th>
                        <th>LAST UPDATED</th>
                        <th>APPROVED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($timeEntry) > 0): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($timeEntry as $entry): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                
                                <?php if (isset($_GET['role']) && $_GET['role'] === "Admin"): ?>
                                    <td><?php echo $entry['email']; ?></td>
                                <?php endif; ?>
                                
                                <td><?php echo $entry['date']; ?></td>
                                <td><?php echo $entry['task_title']; ?></td>
                                <td>
                                    <?php
                                    $time = new DateTime($entry['time']);
                                    echo $time->format('H');
                                    ?> h
                                    <?php
                                    $time = new DateTime($entry['time']);
                                    echo $time->format('i');
                                    ?> m
                                </td>
                                <td><?php echo $entry['updated_at']; ?></td>
                                <td><?php echo $entry['approved']; ?></td>
                                <td>
                                    <button style="--bs-btn-padding-y: 0rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: 0rem;" type="button" class="btn no-outline" onclick="window.location.href='time_entry.php/?id=<?php echo $entry['id']; ?>';">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>
                              
                                    <?php 
                                        
                                      if ($entry['approved'] === 'Pending' && isset($_GET['role']) && $_GET['role'] === "Admin"): ?>
                                        <form method="POST" action="./form_actions/approve_entry.php" class="d-inline">
                                            
                                                <button style="--bs-btn-padding-y: 0rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: 0rem;" class="btn no-outline" type="submit" name="approve" value="<?php echo $entry['id']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                                    </svg>
                                                </button>
                                            
                                                <button style="--bs-btn-padding-y: 0rem; --bs-btn-padding-x: 0rem; --bs-btn-font-size: 0rem;" class="btn no-outline" type="submit" name="reject" value="<?php echo $entry['id']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-x" viewBox="0 0 16 16">
                                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                    </svg>
                                                </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
