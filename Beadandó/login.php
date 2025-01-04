<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="jquery-3.7.1.min.js"></script>
    <title>Bejelentkezés</title>
</head>
<body>
    <div class="card">
    <div class="card-header">Belépés</div>
    <div class="card-body">
        <form action="login.php" method="POST">
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
                        <input type="password" name="password" class="form-control" id="password" placeholder="Jelszó">
                        <label for="password">Jelszó</label>
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
                
                <div class="col-mb-6">
                <button class="btn btn-primary" type="submit">Bejelentkezés</button>
                </div>
                <br>
                <br>
                <p>Nincs még fiókod? <a href="registration.php">Regisztráció</a></p>
</body>
</html>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Adatok begyűjtése az űrlapból
    $vezeteknev = $_POST['vezeteknev'];
    $keresztnev = $_POST['keresztnev'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Előkészített SQL lekérdezés a felhasználó adatainak ellenőrzéséhez
    $sql = "SELECT id, password, role FROM users WHERE vezeteknev = ? AND keresztnev = ? AND role = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Paraméterek hozzárendelése
        $stmt->bind_param("sss", $vezeteknev, $keresztnev, $role);
        
        // Lekérdezés végrehajtása
        $stmt->execute();
        $stmt->store_result();
        
        // Ellenőrizzük, hogy van-e találat
        if ($stmt->num_rows == 1) {
            // Adatok kiolvasása
            $stmt->bind_result($id, $hashed_password, $role);
            $stmt->fetch();

            // Jelszó ellenőrzése
            if (password_verify($password, $hashed_password)) {
                // Ha a jelszó helyes, átirányítás a felhasználói szerepkör alapján
                //session_start();
                $_SESSION['id'] = $id;  // Felhasználó azonosító tárolása session-ben
                $_SESSION['role'] = $role;  // Szerepkör tárolása

                if ($role == 'admin') {
                    header("Location: admin.html");  // Admin irányítópult
                } else {
                    header("Location: welcome.html");  // Felhasználói főoldal
                }
                exit();
            } else {
                echo "Hibás jelszó!";
            }
        } else {
            echo "Nem található ilyen felhasználó!";
        }

        // Lekérdezés lezárása
        $stmt->close();
    } else {
        echo "Hiba történt az SQL előkészítése során: " . $conn->error;
    }

    // Kapcsolat lezárása
    $conn->close();
}
?>