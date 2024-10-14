<?php
start_session();
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

// Pepper für password hashing (wird an das Passwort angehängt)
$pepper = 'yoxxxxxxx45hghjkj';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Salten und peppern (Kochen) ans Passwort ranhängen das passwort hashen
    $salt = bin2hex(random_bytes(22));
    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = password_hash($peppered_password . $salt, PASSWORD_BCRYPT);

    // Gekochtes Passwort und Username der Datenbank speichern
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();

    header("Location: main.php");
    exit();
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
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<!-- Prüfen Ob Passwort mindestens 8 Zeichen lang ist und mindestens eine Zahl und ein Buchstabe enthält -->
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; 
            if (!regex.test(password)) {
                alert('Password must be at least 8 characters long and contain at least one letter and one number.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
