<?php
session_start();

function Connect()
{
    $datenbank = "eulbert_gtodo";
    $host = "localhost";
    $user = "hwalde";
    $passwd = "UG2aepai4g";
    
    // Datenbankverbindung herstellen
    try 
    {
        $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) 
    {
        die("Datenbankverbindung gescheitert: " . $e->getMessage());
    }

    return $db;
}

function Login($pdo_db, $username, $password)
{
    try
    {
        $statement = $pdo_db->prepare("SELECT username, BID FROM users WHERE username =? AND password=?");
        $statement->execute([$username, $password]);
    }
    catch(Exception $e)
    {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }

    $result = $statement->fetchAll();

    if(count($result) != 0)
    {
        $_SESSION['username'] = $result[0]['username'];
        $_SESSION['BID'] = $result[0]['BID'];
        echo "<script type='text/javascript'>location.href = 'https://hmbldtw.spdns.org/~hwalde/web/g_todo_project/lin-todo/dashboard.php';</script>";
        exit();
    }
    else
    {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
   
    <?php 
        if(isset($_POST['form_username']) && isset($_POST['form_password']))
        {
            $username = $_POST['form_username'];
            $password = $_POST['form_password'];
            
            $db = Connect();
            Login($db, $username, $password);
        }
    ?>

    <form method="post">
        <input type="text" id="bnameId" name="form_username" placeholder="Benutzername" aria-label="Benutzername">
        <input type="password" id="passwortId" name="form_password" placeholder="Passwort" aria-label="Passwort">
        <input type="submit" value="Anmelden">
    </form>
</body>
</html>
