<!DOCTYPE html>
<html lang="en">
<?php $pageTitle = "Log In"; include("head.php") ?>
<style>
    html, body {
        height: 100%;
    }
</style>

<?php
$error = "";

$host = "localhost";
$user = "root";
$password = "";
$database = "time registration";

try{
    $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
    if (!empty($email) && !empty($password)) {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email limit 1");
        $stmt->bindParam(":email", $email,PDO::PARAM_STR);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && $password === ($user['password'])){//$user && password_verify($password, $user['password']) for hashed passwords
            header('Location: home.php');
            exit();
        }else{
            $error = "Wrong email or password";
        }
    }else{
        $error = "Please enter both the email and password";
    }


}
?>


<body class="d-flex justify-content-center align-items-center">
<div class="container-fluid h-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-lg-4 d-none d-lg-block">
                <img src="images/login_bg2.jpg" class="img-fluid rounded-start" alt="Login Image" style="height: 450px; object-fit: cover; width: 100%"/>
            </div>
            <div class="col-lg-8">
                <div class="card-body">
                    <h5 class="card-title text-center mb-2">Welcome!</h5>
                    <h6 class="card-subtitle text-center mb-4 text-muted">Please Log In!</h6>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="card-text text-center mt-3"><small class="text-body-secondary">Forgot Password?</small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
