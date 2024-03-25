<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Community";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $filmId = $_GET["id"];
    $username = $_SESSION["username"];

    $query = "SELECT * FROM film WHERE id='$filmId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filmTitle = $row['titolo'];
            $filmYear = $row['anno'];
            $filmDuration = $row['durata'];
            $filmDirector = $row['regista'];
            $filmGenre = $row['genere'];
        }
    } else {
        header("Location: index.php");
        exit();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>Modifica film</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
<div class="container">
    <center>
        <h1>MODIFICA FILM</h1>

        <form method="post" action="<?php echo htmlspecialchars("modifica.php?id=$filmId"); ?>">
            <table>
                <tr>
                    <td>Titolo: </td>
                    <td><input type="text" name="title" value="<?php echo $filmTitle; ?>" required></td>
                </tr>
                <tr>
                    <td>Anno: </td>
                    <td><input type="text" name="year" value="<?php echo $filmYear; ?>" required></td>
                </tr>
                <tr>
                    <td>Durata: </td>
                    <td><input type="text" name="duration" value="<?php echo $filmDuration; ?>" required></td>
                </tr>
                <tr>
                    <td>Regista: </td>
                    <td><input type="text" name="director" value="<?php echo $filmDirector; ?>" required></td>
                </tr>
                <tr>
                    <td>Genere: </td>
                    <td><input type="text" name="genre" value="<?php echo $filmGenre; ?>" required></td>
                </tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
            </table>
            <button type="submit" name="save">SALVA MODIFICHE</button>
        </form>
    </center>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    $filmId = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Community";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $username = $_SESSION["username"];

    $newFilmTitle = $_POST["title"];
    $newFilmYear = $_POST["year"];
    $newFilmDuration = $_POST["duration"];
    $newFilmDirector = $_POST["director"];
    $newFilmGenre = $_POST["genre"];

    $updateQuery = "UPDATE film SET titolo='$newFilmTitle', anno='$newFilmYear', durata='$newFilmDuration', regista='$newFilmDirector', genere='$newFilmGenre', utente='$username' WHERE id='$filmId'";
    
    if ($conn->query($updateQuery) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "<center><p>Errore durante la modifica del film: " . $conn->error . "</p></center>";
    }

    $conn->close();
}
?>
