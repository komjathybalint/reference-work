<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="upload.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="jquery-3.7.1.min.js"></script>
    <title>Tartalom feltöltése</title>
</head>
<body>

<div class="container">
    <h1>Tartalom feltöltése</h1>

    <form action="upload.php" method="post">
        <div class="input-group">
            <label for="title">Cím</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="input-group">
            <label for="content">Tartalom</label>
            <textarea id="content" name="content" rows="10" required></textarea>
        </div>
        <div class="input-group">
            <label for="pictures">Kép URL (opcionális):</label>
            <input type="text" name="pictures" id="pictures"><br>
        </div>
        <input type="submit" value="Feltöltés">
    </form>

    <!-- Üzenetek -->
    <?php if (isset($success_message)): ?>
        <div class="message" style="color: green;"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="message" style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>
</div>
</body>
</html>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Felhasználói adatok lekérése a formból
    $title = $_POST['title'];
    $content = $_POST['content'];
    $pictures = $_POST['pictures']; // opcionális

    // Ellenőrizzük, hogy a szükséges mezők nem üresek-e
    if (!empty($title) && !empty($content)) {
        // SQL beszúrási lekérdezés előkészítése
        $sql = "INSERT INTO games (title, content, pictures) VALUES (?, ?, ?)";

        // Lekérdezés futtatása és ellenőrzése, hogy sikeres volt-e
        if ($stmt = $conn->prepare($sql)) {
            // Paraméterek hozzárendelése
            $stmt->bind_param("sss", $title, $content, $pictures);
        if ($stmt->execute()) {
            echo "Feltöltés sikeres!";
            exit();
        } else {
            echo "Hiba történt: " . $conn->error;
        }
    
        $stmt->close();
    }    
    }
}
// Kapcsolat lezárása
$conn->close();
?>