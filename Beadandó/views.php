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

// Tartalmak lekérdezése
$sql = "SELECT id, title FROM games";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul class = game-list>";
    while ($row = $result->fetch_assoc()) {
        $title = $row['title'];
        
        echo "<li><a href='game_details.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "Nincs elérhető játék.";
}
$conn->close();
?>

<style>

body {
    font-family: 'Arial', sans-serif;
    background-color: royalblue;
    color: #333;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 40px;
}

ul.game-list {
    list-style: none;
    padding: 0;
}

ul.game-list li {
    background-color: #e3eaf1;
    padding: 25px;
    margin-bottom: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

ul.game-list li:hover {
    background-color: #d1d8e5;
}

ul.game-list li a {
    text-decoration: none;
    color: #2980b9;
    font-size: 30px;
    font-weight: bold;
}

ul.game-list li a:hover {
    color: #1a5276;
}

</style>