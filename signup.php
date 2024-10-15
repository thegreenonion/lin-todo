<?php
include 'Hash.php';

$datenbank = "eulbert_gtodo";
$host = "localhost";
$user = "hwalde";
$passwd = "UG2aepai4g";

// Datenbankverbindung herstellen
try {
    $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Datenbankverbindung gescheitert: " . $e->getMessage());
}

function verify_recaptcha($token) {
    $secret = 'YOUR_SECRET_KEY';
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token");
    $responseKeys = json_decode($response, true);

    // Debugging output
    if ($responseKeys === null) {
        error_log("reCAPTCHA response is null. Response: " . $response);
    } else {
        error_log("reCAPTCHA response: " . print_r($responseKeys, true));
    }

    return isset($responseKeys["success"]) && intval($responseKeys["success"]) === 1;
}

function process_form(): bool {
    global $db, $pepper;

    $username = $_POST['username'];
    $password = $_POST['password'];
    $recaptcha_token = $_POST['recaptcha_token'];

    if (!verify_recaptcha($recaptcha_token)) {
        return false;
    }

    // Hash the password with salt and pepper
    $hashed_data = hashPassword($password, $pepper);
    $hashed_password = $hashed_data['hash'];
    $salt = $hashed_data['salt'];

    // Store the username, hashed password, and salt in the database
    $stmt = $db->prepare("INSERT INTO users (username, password, salt) VALUES (:username, :password, :salt)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':salt', $salt);
    $stmt->execute();

    $_SESSION["username"] = $username;
    echo "<script type='text/javascript'>location.href = './main.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (process_form()) {
        // Form processed successfully
    } else {
        echo 'Form processing failed. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LdgSGIqAAAAAOd6RuzDbvejzESk4GzTxIQ90Epd"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form id="signupForm" action="signup.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <input type="hidden" id="recaptcha_token" name="recaptcha_token">
                            <button type="submit" class="btn btn-primary btn-block" onclick="onClick(event)">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function onClick(e) {
            e.preventDefault();
            grecaptcha.enterprise.ready(async () => {
                const token = await grecaptcha.enterprise.execute('6LdgSGIqAAAAAOd6RuzDbvejzESk4GzTxIQ90Epd', {action: 'SIGNUP'});
                document.getElementById('recaptcha_token').value = token;
                document.getElementById('signupForm').submit();
            });
        }
    </script>
</body>
</html>