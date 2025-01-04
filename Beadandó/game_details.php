<?php
// Adatbázis kapcsolat
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

// Adatbázis kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Az id paraméter alapján lekérdezzük a játék részleteit
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Az id paraméter értéke
} else {
    // Ha nincs id paraméter az URL-ben, vissza lehet irányítani egy hibaoldalra vagy listára
    die("Hibás vagy hiányzó azonosító.");
}


$query = "SELECT title, content, pictures FROM games WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $game = $result->fetch_assoc();
    $title = $game['title'];
    $content = $game['content'];
    $pictures = $game['pictures'];
} else {
    echo "A játék nem található.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="jquery-3.7.1.min.js"></script>
    
    <title><?php echo $title; ?></title>
    <body>
    <div class="container">
        <div class="game-details">
            <h1><?php echo htmlspecialchars($game['title']); ?></h1>
            <p><?php echo htmlspecialchars($game['content']); ?></p>

            <?php if (!empty($game['pictures'])): ?>
                <img src="<?php echo htmlspecialchars($game['pictures']); ?>" alt="Játék képe" class="game-image">
            <?php endif; ?>
        </div>
    </div>
</body>
    <style>

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
    background: royalblue;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    color: #34495e;
    margin-bottom: 20px;
    font-size: 28px;
}

.game-details {
    text-align: center;
    margin-top: 20px;
}

p {
    font-size: 18px;
    line-height: 1.6;
    color: #555;
    text-align: justify;
    margin-bottom: 20px;
}

.game-image {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

    </style>
</html>