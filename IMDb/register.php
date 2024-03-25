<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>Registrazione</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
<div class="container">
<center>
    <h1>REGISTRAZIONE</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <td>Nome utente: </td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
        </table>
        <button type="submit">REGISTRATI</button>
    </form>
</center>
</div>  

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Community";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM utenti WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<center><p>Nome utente o email già in uso.</p></center>";
    } else {
        $insertQuery = "INSERT INTO utenti (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "<center><p>Errore durante la registrazione: " . $conn->error . "</p></center>";
        }
    }

    $conn->close();
}
?>
