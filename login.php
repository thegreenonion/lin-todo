<?php
include("Hash.php");

include("conn.php");

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
    if(!$fetched_statement)
    {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
        exit();
    }
    $db_password = $fetched_statement['password'];
    $salt = $fetched_statement['salt'];
    
    $pepper = 'yoxxxxxxx45hghjkj';
    $verification_result = verifyPassword($password, $db_password, $salt, $pepper);

    // compare database password with freshly hashed password
    if ($verification_result['hashesMatch'] == FALSE)
    {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
        exit();
    }

    // request username and BID with hashed password
    try
    {
        $statement = $pdo_db->prepare("SELECT username, BID FROM users WHERE username =? AND password=?");
        $statement->execute([$username, $verification_result['hashed_password']]);
    }
    catch(Exception $e)
    {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }

    $result = $statement->fetch();
    // set session variables and redirect to dashboard if result of query is not 0
    if(count($result) != 0)
    {
        $_SESSION['username'] = $result['username'];
        $_SESSION['BID'] = $result['BID'];
        echo "<script type='text/javascript'>location.href = './main.php?action=dashboard';</script>";
        exit();
    }
    else
    {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
    }
}
?>
<html>
<body>
    <?php 
        if(isset($_POST['form_username']) && isset($_POST['form_password']))
        {
            $username = $_POST['form_username'];
            $password = $_POST['form_password'];
            
            Login($db, $username, $password);
        }
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body bg-light">
                        <form method="post" action="" id="loginform">
                            <div class="form-group">
                                <label for="form_username">Benutzername:</label>
                                <input type="text" id="form_username" name="form_username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="form_password">Passwort:</label>
                                <input type="password" id="form_password" name="form_password" class="form-control" required>
                            </div>
                            <button style="margin-top: 5px" type="submit" class="btn btn-primary btn-block">Einloggen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>