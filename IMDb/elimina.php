<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Community";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $filmId = $_GET["id"];

    $deleteQuery = "DELETE FROM film WHERE id='$filmId'";
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Errore durante l'eliminazione del film: " . $conn->error;
    }

    $conn->close();
}
?>
