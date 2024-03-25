<?php
session_start();

$currentUsername = $_SESSION["username"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Community";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

$searchTerm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["term"])) {
    $searchTerm = $_POST["term"];

    $searchQuery = "SELECT * FROM film WHERE 
                    titolo LIKE '%$searchTerm%' OR 
                    anno LIKE '%$searchTerm%' OR 
                    durata LIKE '%$searchTerm%' OR 
                    regista LIKE '%$searchTerm%' OR 
                    genere LIKE '%$searchTerm%' OR 
                    utente LIKE '%$searchTerm%'";
    
    $searchResult = $conn->query($searchQuery);
} else {
    $searchResult = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>Ricerca film</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
<div class="index">
    <center>
        <h1>Ricerca</h1>

        <a href="index.php"><button>TORNA ALLA PAGINA PRINCIPALE</button></a><br><br>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="term">Cerca:</label>
            <input type="text" name="term" value="<?php echo $searchTerm; ?>">
            <button type="submit">CERCA</button>
        </form>

        <br>
        
        <?php
        if ($searchResult !== null) {
            if ($searchResult->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Titolo</th><th>Anno</th><th>Durata</th><th>Regista</th><th>Genere</th><th>Utente</th><th>Azioni</th></tr>";
                while ($row = $searchResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['titolo'] . "</td>";
                    echo "<td>" . $row['anno'] . "</td>";
                    echo "<td>" . $row['durata'] . "</td>";
                    echo "<td>" . $row['regista'] . "</td>";
                    echo "<td>" . $row['genere'] . "</td>";
                    echo "<td>" . $row['utente'] . "</td>";
                    echo "<td>";

                    if ($currentUsername === $row['utente']) {
                        echo "<a href='modifica.php?id=" . $row['id'] . "'><button type='button'>MODIFICA</button></a><br>";
                        echo "<a href='elimina.php?id=" . $row['id'] . "'><button type='button'>ELIMINA</button></a>";
                    } else {
                        echo "Non autorizzato";
                    }

                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nessun risultato trovato.</p>";
            }
        }
        ?>
    </center>
</div>
</body>
</html>
