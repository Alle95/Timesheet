<?php
$pageTitleOptions = array("Create user", "Edit user");
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $pageTitle = $pageTitleOptions[1];
} else {
    $pageTitle = $pageTitleOptions[0];
}
$role = array("Admin", "Developer");
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
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = [];
if ($user_id > 0) {
    $conn = new mysqli("localhost", "root", "", "time registration");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT first_name, last_name, phone_number, email, password, adress, hire_date, leave_date, role 
            FROM users 
            WHERE id = $user_id limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = [
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'phone_number' => $row['phone_number'],
                'email' => $row['email'],
                'password' => $row['password'],
                'adress' => $row['adress'],
                'hire_date' => $row['hire_date'],
                'leave_date' => $row['leave_date'],
                'role' => $row['role']
            ];
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">No user found!</div>';
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>

<body>
    <?php include("menu.php");
    ?>
    <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="card shadow-lg mb-3" style="max-width: 750px;">
                <form class="row" form method="POST" action="form_actions/user_save.php">
                    <input type="hidden" name="id" value="<?=$user_id?>">
                    <div class="col-12 mt-2 mb-2">
                        <h2 class="text-center">
                            <?php
                            if (isset($_GET['id']) && $_GET['id'] > 0) {
                                echo "Edit";
                            } else {
                                echo "Create New";
                            }
                            ?>
                            User</h2>
                        <?php
                        if (isset($_GET['message']) && $_GET['message'] === 'success') {
                            echo '<div class="alert alert-success" role="alert">Registration Successful!</div>';
                        } else if (isset($_GET['message']) && $_GET['message'] === 'error') {
                            echo '<div class="alert alert-danger" role="alert">This email has already been used!</div>';
                        } else if (isset($_GET['message']) && $_GET['message'] === 'edit.success') {
                            echo '<div class="alert alert-success" role="alert">This user has been updated!</div>';
                        }else if (isset($_GET['message']) && $_GET['message'] === 'del.success') {
                            echo '<div class="alert alert-success" role="alert">This user has been deleted!</div>';
                        }else if (isset($_GET['message']) && $_GET['message'] === 'error.edit') {
                            echo '<div class="alert alert-danger" role="alert">Something went wrong, please try again!</div>';
                        }else if (isset($_GET['message']) && $_GET['message'] === 'password_mismatch') {
                            echo '<div class="alert alert-danger" role="alert">Password mismatch!</div>';
                        }
                        ?>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="firstName" class="form-label">First name</label>
                        <input type="text" class="form-control" name="firstName" id="firstName" value="<?= $user['first_name'] ?? '' ?>" required>
                        <div class="invalid-feedback">Valid first name is required.</div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="lastName" class="form-label">Last name</label>
                        <input type="text" class="form-control" name="lastName" id="lastName" value="<?= $user['last_name'] ?? '' ?>" required>
                        <div class="invalid-feedback">Valid last name is required.</div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="" value="<?= $user['phone_number'] ?? '' ?>" required>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" value="<?= $user['email'] ?? '' ?>">
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="password1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password1" id="password1" placeholder="" value="<?= $user['password'] ?? '' ?>" required>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <label for="password2" class="form-label">Repeat Password</label>
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="" value="<?= $user['password'] ?? '' ?>" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="St. Example 123, City, Country" value="<?= $user['adress'] ?? '' ?>" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="hireDate" class="form-label">Hire date</label>
                        <input type="date" class="form-control" name="hireDate" id="hireDate" value="<?= $user['hire_date'] ?? '' ?>" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="leaveDate" class="form-label">Termination date</label>
                        <input type="date" class="form-control" name="leaveDate" value="<?= $user['leave_date'] ?? '' ?>" id="leaveDate">
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" name="role" id="role" >
                            <option value=""> <?= $user['role'] ?? 'Choose here' ?></option>
                            <?php
                            foreach ($role as $role) :
                            ?>
                                <option value="<?= htmlspecialchars($role) ?>"> <?= htmlspecialchars($role) ?> </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="leaveDate" class="form-label">Photo</label><br>
                        <input type="file" class="form-control" id="photo" name="filename">
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
                    <?php

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
    </div>
</body>
</html>
