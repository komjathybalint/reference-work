<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Felhasználók lekérdezése
$result = $conn->query("SELECT id, vezeteknev, keresztnev, email, role FROM users");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Felhasználó törlése
        $userId = $_POST['user_id'];
        $deleteSql = "DELETE FROM users WHERE id=?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        header("Location: users.php"); // Frissíti az oldalt
        exit();
    } elseif (isset($_POST['edit'])) {
        // Felhasználó szerkesztésének logikája itt
        $userId = $_POST['user_id'];
        $updateSql = "UPDATE users WHERE id=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $userId);
        $stmt->execute();
        header("Location: users.php"); // Frissíti az oldalt
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználók kezelése</title>
    <link rel="stylesheet" href="users.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="jquery-3.7.1.min.js"></script>
</head>
<body>
    <h1>Felhasználók kezelése</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Email</th>
                <th>Szerepkör</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['keresztnev']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" onclick="return confirm('Biztosan törlöd ezt a felhasználót?')">Törlés</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nincs felhasználó a rendszerben</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>