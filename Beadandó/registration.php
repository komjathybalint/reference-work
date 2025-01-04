<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Irányítópult</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="jquery-3.7.1.min.js"></script>
</head>

<div class="card">
    <div class="card-header">Regisztráció</div>
    <div class="card-body">
        <form action="registration.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="vezeteknev" class="form-control" id="vezeteknev" placeholder="Vezetéknév">
                        <label for="vezeteknev">Vezetéknév</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="keresztnev" class="form-control" id="keresztnev" placeholder="Keresztnév">
                        <label for="keresztnev">Keresztnév</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Jelszó">
                        <label for="password">Jelszó</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="password" name="password_ujra" class="form-control" id="password_ujra" placeholder="Jelszó újra">
                        <label for="password_ujra">Jelszó újra</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        </select><br><br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <button type="submit" class="btn btn-primary">Regisztráció</button>
                        <a href="login.php"><button class="btn btn-primary">Belépés</button></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
session_start();
// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";  // Adatbázis felhasználónév
$password = "";      // Adatbázis jelszó
$dbname = "admin";  // Az adatbázis neve

$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizd az adatbáziskapcsolatot
if ($conn->connect_error) {
    die("Kapcsolat sikertelen: " . $conn->connect_error);
}

// Regisztrációs űrlap kezelése
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Adatok begyűjtése az űrlapból
    $vezeteknev = $_POST['vezeteknev'];
    $keresztnev = $_POST['keresztnev'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Jelszó titkosítása a biztonság érdekében
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Felhasználó beszúrása az adatbázisba
    $sql = "INSERT INTO users (vezeteknev, keresztnev, email, password, role) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Paraméterek hozzárendelése
        $stmt->bind_param('sssss', $vezeteknev, $keresztnev, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Regisztráció sikeres!";
        header("Location: login.php");  // Átirányítás a bejelentkező oldalra
        exit();
    } else {
        echo "Hiba történt: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
}
?>