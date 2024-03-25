<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Biasiolo Matteo">
    <title>Profilo</title>
    <link rel="stylesheet" href="PHPcss.css">
</head>

<body>
<div class="container">
<center>
    <h1>PROFILO</h1>
    
    <?php
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "<h2>Benvenuto, $username!</h2>";
        echo '<a href="logout.php"><button>LOGOUT</button></a>';
    } else {
        echo '<a href="login.php"><button>LOGIN</button></a><br><br>';
    }
    ?>

</center>
</div>
</body>
</html>