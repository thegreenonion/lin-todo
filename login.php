<?php
function Connect()
{
    include("conn.php");
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
            
            $db = Connect();
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
                                <label for="form_username">Username:</label>
                                <input type="text" id="form_username" name="form_username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="form_password">Password:</label>
                                <input type="password" id="form_password" name="form_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Einloggen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>