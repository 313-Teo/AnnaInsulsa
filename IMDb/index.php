<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>IMDb</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
<div class="index">
    <center>
        <h1>IMDb COMMUNITY DATABASE</h1>

        <a href="profilo.php"><button>PROFILO</button></a>
        <a href="aggiungi.php"><button>AGGIUNGI UN NUOVO FILM</button></a>
        <a href="cerca.php"><button>CERCA UN FILM</button></a>
        <a href="about.php"><button>ABOUT</button></a>

        <br>
        <br>

        <?php
        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Community";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connessione al database fallita: " . $conn->connect_error);
        }

        $currentUsername = $_SESSION["username"];

        $query = "SELECT * FROM film";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Titolo</th><th>Anno</th><th>Durata</th><th>Regista</th><th>Genere</th><th>Utente</th><th>Azioni</th></tr>";

            while ($row = $result->fetch_assoc()) {
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
            echo "<p>Nessun film disponibile.</p>";
        }

        $conn->close();
        ?>
    </center>
</div>
</body>
</html>
