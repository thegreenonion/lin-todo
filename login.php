<?php
include("Hash.php");

include("conn.php");

/**
 * Logs in a user by verifying the provided username and password against the credentials in the database.
 * 
 * Note: Each user has a unique username.
 * 
 * parameters:
 * - $pdo_db: PDO database connection
 * - $username: username of the user
 * - $password: password of the user
 */
function Login($pdo_db, string $username, string $password)
{
    // request username, BID, hashed password and salt of username from database
    try {
        $statement = $pdo_db->prepare("SELECT username, BID, password, salt FROM users WHERE username =?");
        $statement->execute([$username]);
    } catch (Exception $e) {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }
    $fetched_statement = $statement->fetch(); // fetch request

    // check if database has returned a result (array is not empty)
    if (!$fetched_statement) {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
        exit();
    }
    $bid = $fetched_statement['BID'];
    $db_password = $fetched_statement['password'];
    $salt = $fetched_statement['salt'];

    $pepper = 'yoxxxxxxx45hghjkj';
    $verification_result = verifyPassword($password, $db_password, $salt, $pepper);

    // check if verification was successful
    if ($verification_result['hashesMatch'] == FALSE) {
        echo "Die Eingabe war falsch. Bitte versuche es normal.";
        exit();
    }

    // set session variables and redirect to dashboard if password is correct
    $_SESSION['username'] = $username;
    $_SESSION['BID'] = $bid;
    echo "<script type='text/javascript'>location.href = './main.php?action=dashboard';</script>";
    exit();
}
?>
<html>

<body>
    <?php
    if (isset($_POST['form_username']) && isset($_POST['form_password'])) {
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
                                <input type="text" id="form_username" name="form_username" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="form_password">Passwort:</label>
                                <input type="password" id="form_password" name="form_password" class="form-control"
                                    required>
                            </div>
                            <button style="margin-top: 5px" type="submit"
                                class="btn btn-primary btn-block">Einloggen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>