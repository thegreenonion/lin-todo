<?php
session_start();

function CONNECT()
{
    $datenbank = "eulbert_gtodo";
    $host = "localhost";
    $user = "hwalde";
    $passwd = "UG2aepai4g";
    
    // Datenbankverbindung herstellen
    try {
        $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Datenbankverbindung gescheitert: " . $e->getMessage());
    }

    return $db;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
   
    <form action="dashboard.php">
        <input type="text" name="form_username">
        <input type="password" name="form_password">
        <input type="submit">
    </form>
    
    <?php 
        if(isset($_POST['form_username']) && isset($_POST['form_password']))
        {
            $db = CONNECT();
        }
    ?>
</body>
</html>