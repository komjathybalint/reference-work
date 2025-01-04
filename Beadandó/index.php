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

    // Ha a felhasználó már bejelentkezett, átirányítod a megfelelő oldalra
    if (isset($_SESSION['id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin.html");
        exit();
    } 
    } 
    else {
    // Ha nincs bejelentkezve, átirányítjuk a bejelentkezés oldalra
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stilus.css">
    <title>PlayStation</title>
</head>
<body>

    <center><img class="pslogo" src="pslogo.png" alt="pslogo" height="120" width="512"></center>
    <br>
        <div class="button-container">
            <button class="button" onclick="window.location.href='1.html'">Megjelenés</button>
            <button class="button" onclick="window.location.href='2.html'">Hardver</button></a>
            <button class="button" onclick="window.location.href='3.html'">Kezdeti játékok</button></a>
            <button class="button" onclick="window.location.href='views.php'">Játékok</button></a>
        </div>

        <br>

    <!-- Keresőmező -->
    <input type="text" id="search-input" placeholder="Játék neve" onkeyup="searchGames()">
    <!-- Az eredmények itt jelennek meg -->
    <div id="search-result" class="search-result"></div>

    <script>
    function searchGames() {
    var query = document.getElementById('search-input').value;

    if (query.length > 0) {
        // AJAX kérés elküldése a szervernek
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'search.php?query=' + query, true);
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('search-result').innerHTML = this.responseText;
            }
        };
        xhr.send();
    } else {
        document.getElementById('search-result').innerHTML = '';
    }
}

// Találatok kattintása esetén átnavigálunk a részletekhez
function goToGameDetails(id) {
    window.location.href = 'game_details.php?id=' + id;
}
</script>

    <style>
        #search-input {
            width: 15%; /* Keresőmező hosszabbítása */
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Találatok konténere */
        .search-result {
            border: 1px solid #ccc;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            background-color: white;
            width: 17%; /* Ugyanakkora, mint a keresőmező */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Árnyék a találatokhoz */
            margin-top: 5px;
            z-index: 1000; /* Előrébb hozza a találatokat a rétegek között */
        }

        /* Egyedi találatok stílusa */
        .search-result div {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .search-result div:hover {
            background-color: #f0f0f0;
        }

        /* Utolsó elemnél nincs alsó szegély */
        .search-result div:last-child {
            border-bottom: none;
        }
    </style>


    <script>
        function bigImg(x){
            x.style.height = "65px"
            x.style.width = "230px"
        }
        function normalImg(x){
            x.style.height = "60px"
            x.style.width = "218px"
        }
    </script>
    <br>
    <br> 
    <div class="slideshow">
        <div class="slide">
          <img src="nfsnagy.jpg" alt="nfsnagy">
        </div>
        <div class="slide">
          <img src="cpnagy.jpg" alt="cpnagy">
        </div>
        <div class="slide">
          <img src="codmwnagy.jpg" alt="codmwnagy">
        </div>
        <div class="slide">
            <img src="mmnagy.jpg" alt="mmnagy">
        </div>
      </div>
      <br>
    <center>
        <video width="818" height="460" controls>
            <source src="psvideo.mp4" type="video/mp4">
        </video>
    </center>
    <br>
    <a href="https://www.cyberpunk.net/hu/en/"><img onmouseover="bigImg2(this)" onmouseout="normalImg2(this)" src="cpkicsi.jpg" alt="cpkicsi" class="rounded-image"></a>
    <a href="https://www.playstation.com/en-hu/games/need-for-speed-payback/"><img onmouseover="bigImg2(this)" onmouseout="normalImg2(this)" src="nfskicsi.jpg" alt="nfskicsi" class="rounded-image"></a>
    <a href="https://www.playstation.com/en-hu/god-of-war/"><img onmouseover="bigImg2(this)" onmouseout="normalImg2(this)" src="gowkicsi.jpg" alt="gowkicsi" class="rounded-image"></a>
    <a href="https://www.playstation.com/hu-hu/games/marvels-spider-man-remastered/pc/"><img onmouseover="bigImg2(this)" onmouseout="normalImg2(this)" src="smkicsi.jpg" alt="smkicsi" class="rounded-image"></a>

    <script>
        function bigImg2(x){
            x.style.height = "49.5%"
            x.style.width = "19.5%"
        }
        function normalImg2(x){
            x.style.height = "49%"
            x.style.width = "19%"
        }
    </script>
</body>
</html>