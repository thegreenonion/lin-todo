<?php
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
function hash_password($password, $salt, $pepper)
{
    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = password_hash($peppered_password . $salt, PASSWORD_BCRYPT);

    return $hashed_password;
}

function Login($pdo_db, $username, $password)
{
    // request hashed password from database
    try
    {
        $statement = $pdo_db->prepare("SELECT username, password, salt FROM users WHERE username =?");
        $statement->execute([$username]);
    }
    catch(Exception $e)
    {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }
    
    // fetch database password + salt and hash password of form with salt and pepper 
    $fetched_statement = $statement->fetch();
    $db_password = $fetched_statement['password'];
    $salt = $fetched_statement['salt'];
    
    $pepper = 'yoxxxxxxx45hghjkj';
    $hashed_password = hash_password($password, $salt, $pepper);

    // compare database password with freshly hashed password
    if ($db_password != $hashed_password)
    {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
        exit();
    }

    // request username and BID with hashed password
    try
    {
        $statement = $pdo_db->prepare("SELECT username, BID FROM users WHERE username =? AND password=?");
        $statement->execute([$username, $hashed_password]);
    }
    catch(Exception $e)
    {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }

    $result = $statement->fetch();
    var_dump($result);

    // set session variables and redirect to dashboard if result of query is not 0
    if(count($result) != 0)
    {
        $_SESSION['username'] = $result['username'];
        $_SESSION['BID'] = $result['BID'];
        echo "<script type='text/javascript'>location.href = 'https://hmbldtw.spdns.org/~eulbert/web/gtodo/lin-todo/main.php';</script>";
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
