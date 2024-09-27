<?php
$dsn = 'mysql:host=localhost;dbname=time registration';
$username = 'root';
$password = '';
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $entryId = null;
    $status = null;

    if (isset($_POST['approve'])) {
        $entryId = $_POST['approve'];
        $status = 'Yes';
    } elseif (isset($_POST['reject'])) {
        $entryId = $_POST['reject'];
        $status = 'No';
    }

    if ($entryId && $status) {
        $query = 'UPDATE time_entries SET approved = :status WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $entryId, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../list_entries.php?role=Admin');
        exit;
    }

} catch (PDOException $e) {
    // Print error message for debugging
    echo "Error: " . $e->getMessage();
}
?>
