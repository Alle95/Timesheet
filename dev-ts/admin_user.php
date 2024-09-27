<?php

$host = 'localhost';  
$db = 'time registration';  
$user = 'root';        
$pass = '';       
$charset = 'utf8mb4';  
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

$filteredUsers = []; // Inițializare variabilă pentru a evita erori

try {
  // Creare conexiune PDO
  $pdo = new PDO($dsn, $user, $pass, $options);

  // Construirea interogării SQL
  $sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name, id, email, phone_number, role 
          FROM users";

  // Adăugarea condiției WHERE dacă există un termen de căutare
  if (isset($_GET['search']) && $_GET['search'] !== '') {
    $sql .= ' WHERE CONCAT(first_name, " ", last_name) LIKE :search1
        OR email LIKE :search2
        OR phone_number LIKE :search3
        OR role LIKE :search4';
}

  // Pregătirea interogării
  $stmt = $pdo->prepare($sql);

  // Legarea parametrilor pentru fiecare apariție a lui :search
  if (isset($_GET['search']) && $_GET['search'] !== '') {
      $search = '%' . $_GET['search'] . '%';
      $stmt->bindValue(':search1', $search, PDO::PARAM_STR);
      $stmt->bindValue(':search2', $search, PDO::PARAM_STR);
      $stmt->bindValue(':search3', $search, PDO::PARAM_STR);
      $stmt->bindValue(':search4', $search, PDO::PARAM_STR);
  }

  // Executarea interogării
  $stmt->execute();
  $filteredUsers = $stmt->fetchAll();

} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}

$pageTitle = "Users list";  

?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>

    <body>
        <?php include("menu.php"); ?>

        <div class="container mt-5">
            <div class="row mb-3">
                <!-- Search User Form -->
                <div class="col-md-8">
                    <form class="d-flex" method="GET" action="">
                        <input type="text" class="form-control me-2" name="search" id="search" placeholder="Search user by attributes" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"> 
                        <button class="btn btn-outline-dark" type="submit">Search</button>
                    </form>
                </div>

                <!-- Create New User Button -->
                <?php
                if (isset($_GET['role']) && $_GET['role'] === "admin") {
                ?>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-outline-dark" onclick="window.location.href='create_users.php';">Create new user</button>
                    </div>
                <?php
                }
                ?>
            </div>

            <h2 class="mb-4">User List</h2>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($filteredUsers) > 0):
                        foreach ($filteredUsers as $user) :
                    ?>
                        <tr>
                        
                        <td>
   
                        <a href="<?php echo (isset($_GET['role']) && $_GET['role'] === "admin") ? 'create_users.php?id=' . urlencode($user['id']) : 'user_profile.php?id=' . urlencode($user['id']); ?>" style="text-decoration: none; color: inherit;">
    <?= htmlspecialchars($user['full_name']) ?>
</a>

</td>

                            <td><a href="user_profile.php?id=<?= $user['id'] ?>" style="text-decoration: none; color: inherit;"><?= htmlspecialchars($user['email']) ?></a></td>
                            <td><a href="user_profile.php?id=<?= $user['id'] ?>" style="text-decoration: none; color: inherit;"><?= htmlspecialchars($user['phone_number']) ?></a></td>
                            <td><a href="user_profile.php?id=<?= $user['id'] ?>" style="text-decoration: none; color: inherit;"><?= htmlspecialchars($user['role']) ?></a></td>
                        </tr>
                    <?php
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="4" class="text-center">No users found</td>
                        </tr>
                    <?php
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
