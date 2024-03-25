<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>Aggiungi film</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
<div class="container">
    <center>
        <h1>AGGIUNGI UN NUOVO FILM</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table>
                <tr>
                    <td>Titolo: </td>
                    <td><input type="text" name="title" required></td>
                </tr>
                <tr>
                    <td>Anno: </td>
                    <td><input type="text" name="year" required></td>
                </tr>
                <tr>
                    <td>Durata: </td>
                    <td><input type="text" name="duration" required></td>
                </tr>
                <tr>
                    <td>Regista: </td>
                    <td><input type="text" name="director" required></td>
                </tr>
                <tr>
                    <td>Genere: </td>
                    <td><input type="text" name="genre" required></td>
                </tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
            </table>
            <button type="submit">AGGIUNGI FILM</button>
        </form>
    </center>
</div>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Community";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $username = $_SESSION["username"];
    
    $title = $_POST["title"];
    $year = $_POST["year"];
    $duration = $_POST["duration"];
    $director = $_POST["director"];
    $genre = $_POST["genre"];

    $insertQuery = "INSERT INTO film (titolo, anno, durata, regista, genere, utente) VALUES ('$title', '$year', '$duration', '$director', '$genre', '$username')";
    
    if ($conn->query($insertQuery) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "<center><p>Errore durante l'inserimento del film: " . $conn->error . "</p></center>";
    }

    $conn->close();
}
?>
