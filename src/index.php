<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Studenten lijst</title>
</head>
<body>
    <header>
        <h1>Studenten Lijst: WEB2A</h1>
    </header>
    
    <div class="filter">
        <input type="text" id="searchInput" placeholder="Zoeken">
        <select id="sortSelect">
            <option value="name-asc">Naam (A-Z)</option>
            <option value="name-desc">Naam (Z-A)</option>
        </select>
        
        <a href="csv.php">Exporteer naar CSV</a>
        <a href="pdf.php">Exporteer naar PDF</a>

    </div>

    <div class="products">
        <?php
        require '../vendor/autoload.php';

        // $dotenv = Dotenv\Dotenv::createImmutable('./');
        $dotenv = Dotenv\Dotenv::createImmutable( __DIR__ . '/');
        $dotenv->load();
       
       // Laad de .env-variabelen
      
       
         $servername = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $dbname = $_ENV['DB_NAME'];

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connectie mislukt: " . $conn->connect_error);
        }
       
        
        

        $query = "SELECT * FROM studenten";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="student-card">';
                echo '<h2>' . $row['voornaam'] . ' ' . $row['achternaam'] . '</h2>';
                echo '<div class="student-details">';
                echo '<p>Email: <a href="send_email.php?email=' . urlencode($row['email']) . '&name=' . urlencode($row['voornaam']) . '">' . $row['email'] . '</a></p>';
                echo '<p>Telefoonnummer: ' . $row['telefoonnummer'] . '</p>';
                echo '<img src="image/' . $row['foto'] . '" alt="Student Foto">';
                echo '</div>';
                echo '</div>';

            }
        } else {
            echo "Geen studenten gevonden.";
        }

        $conn->close();
        ?>
    </div>

    <footer>
        <h1>Roney Zakko</h1>
    </footer>

    <script src="script.js"></script>
</body>
</html>
