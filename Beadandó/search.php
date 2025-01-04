<?php
// Kapcsolat az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Keresési lekérdezés kezelése
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // A játékok keresése a név alapján (LIKE operátor a részleges egyezéshez)
    $sql = "SELECT * FROM games WHERE title LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Találatok megjelenítése
        while ($row = $result->fetch_assoc()) {
            // Megjelenítjük az eredményt, és a kattintáskor az adott játék oldalára navigálunk
            echo "<div onclick=\"goToGameDetails(" . $row['id'] . ")\">" . $row['title'] . "</div>";
        }
    } else {
        echo "<div>Nincs találat.</div>";
    }
}

$conn->close();
?>
