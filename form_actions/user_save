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
    $user_id = intval(isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $first_name = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $last_name  = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $hire_date = isset($_POST['hireDate']) ? $_POST['hireDate'] : '';
    $leave_date = isset($_POST['leaveDate']) ? $_POST['leaveDate'] : '';
    if ($password1 !== $password2) {
        header('Location: ../create_users.php?message=password_mismatch'); // Redirect to the form page
        exit();
    } else {
        $conn = new mysqli("localhost", "root", "", "time registration");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($user_id === 0) {
            //  print_r(1);exit;
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, adress, email, phone_number, password, role, hire_date, leave_date) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $first_name, $last_name, $address, $email, $phone, $password1, $role, $hire_date, $leave_date);
            if ($stmt->execute()) {
                header('Location: ../create_users.php?message=success'); // Redirect to the form page
            } else {
                header('Location: ../create_users.php?message=email');
            }
        } else { 
            // print_r(2);exit;
            $stmt = $conn->prepare("UPDATE users 
                                    SET first_name = ?, last_name = ?, adress = ?, email = ?, phone_number = ?, password = ?, role = ?,
                                    hire_date = ?, leave_date = ?
                                    WHERE id = $user_id");
        // var_dump($stmt);exit;
            $stmt->bind_param("sssssssss", $first_name, $last_name, $address, $email, $phone, $password1, $role, $hire_date, $leave_date);
            if ($stmt->execute()) {
                header('Location: ../create_users.php?message=edit.success'); // Redirect to the form page
            } else {
                header('Location: ../create_users.php?message=error.edit');
            }
        }
        $stmt->close();
        $conn->close();
    }
} elseif(isset($_POST['delete'])) {
    $user_id = intval(isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $conn = new mysqli("localhost", "root", "", "time registration");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM users WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        header('Location: ../create_users.php?message=del.success');
      } else {
        echo "Error deleting record: " . $conn->error;
      }
      
      $conn->close();
}
?>
