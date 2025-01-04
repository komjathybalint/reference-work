<?php
session_start();

// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Felhasználók száma
$sql_total_users = "SELECT COUNT(*) as total FROM users";
$result_total_users = $conn->query($sql_total_users);
$total_users = 0;

if ($result_total_users->num_rows > 0) {
    $row = $result_total_users->fetch_assoc();
    $total_users = $row['total'];
}

// Legutóbbi felhasználók
$sql_recent_users = "SELECT keresztnev, email, created_at FROM users ORDER BY created_at DESC LIMIT 5";
$recent_users_result = $conn->query($sql_recent_users);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Irányítópult</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
    <header>
        <h1>Irányítópult</h1>
        <p>Üdvözlünk!</p>
    </header>

    <div class="dashboard">
    <h2>Összefoglaló</h2>
    <p>Regisztrált felhasználók száma: <strong><?php echo $total_users; ?></strong></p>

    <h2>Legutóbbi felhasználók</h2>
    <table>
        <tr>
            <th>Név</th>
            <th>Email</th>
            <th>Regisztráció dátuma</th>
        </tr>
        <?php

        if ($recent_users_result->num_rows > 0) {
            while ($user = $recent_users_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $user['keresztnev'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['created_at'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nincsenek új felhasználók.</td></tr>";
        }
        ?>
    </table>
</div>

<div>
<div class="actions">
    <h2>Gyorslinkek</h2>
    <button class="button" onclick="window.location.href='users.php'">Felhasználók kezelése</button>
    <button class="button" onclick="window.location.href='upload.php'">Feltöltés</button>
 
</div>
</div>

    <div>

    <footer>
        <p>&copy; Admin felület</p>
    </footer>
</div>

</body>
</html>
