<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>Login</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
    <div class="container">
        <center>
            <h1>LOGIN</h1>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table>
                    <tr>
                        <td>Nome utente: </td>
                        <td><input type="text" name="username" required></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" name="password" required></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                </table>
                <button type="submit">LOGIN</button>
            </form>
            <a href="register.php"><button>REGISTRATI</button></a>
        </center>
    </div>  
</body>
</html>

<?php
session_start();

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
    $password = $_POST["password"];

    $query = "SELECT * FROM utenti WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["username"] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "<center><p>Password errata</p></center>";
        }
    } else {
        echo "<center><p>Nome utente non trovato</p></center>";
    }

    $conn->close();
}
?>
