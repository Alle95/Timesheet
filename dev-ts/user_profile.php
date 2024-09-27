<?php
$pageTitle = "User Profile";
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
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = [];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT  first_name, last_name, email, phone_number, role
        FROM users
        WHERE id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    $user = [
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'role' => $row['role']
        ];
    }
} else {
    echo '<div class="alert alert-danger" role="alert">No user found!</div>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle;
           ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

        <style>
            .custom-container {
                width: 90%; /* Custom width for the navbar */
                margin: 0 auto; /* Center it */
            }
        </style>
    </head>
    <body>
    <?php include("menu.php");?>
    <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="card shadow-lg mb-3" style="max-width: 750px;">
                <form class="row">
                    <div class="py-5 text-center">
                        <img src="images/Icon site.jpg" class="img-fluid rounded-circle" alt="User Photo"
                            style="max-width: 150px; height: auto">
                    </div>
                    <div class="col-12 col-sm-6 md-3">
                        <label for="exampleFormControlInput1" class="form-label">First Name</label>
                        <input type="text" class="form-control"  value="<?= $user['first_name'] ?? '' ?>"  id="exampleFormControlInput1"
                            value="<?= $user['first_name'] ?? '' ?>" readonly>
                    </div>
                    <div class="col-12 col-sm-6 md-3">
                        <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                        <input type="text" class="form-control"  value="<?= $user['last_name'] ?? '' ?>"  id="exampleFormControlInput1"
                             readonly>
                    </div>
                    <div class="col-12 col-sm-6 md-3">
                        <label for="exampleFormControlInput1" class="form-label">Phone number</label>
                        <input type="tel" class="form-control"  value="<?= $user['phone_number'] ?? '' ?>"  id="exampleFormControlInput1"
                            readonly>
                    </div>
                    <div class="col-12 col-sm-6 md-3">
                        <label for="exampleFormControlInput1" class="form-label">Role</label>
                        <input type="text" class="form-control"  value="<?= $user['role'] ?? '' ?>"  id="exampleFormControlInput1"
                             readonly>
                    </div>
                    <div class="col-12">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email" class="form-control"  value="<?= $user['email'] ?? '' ?>"  id="exampleFormControlInput1"
                            readonly>
                    </div>
                </form>
                <footer class="my-5 pt-5 text-body-secondary text-center text-small">
                    <p class="mb-1">&copy; 2024 User Profile </p>
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
