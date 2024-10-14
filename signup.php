<?php
include("Hash.php");

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hashe das Passwort und den Salt
    $hashed_data = hashPassword($password, $pepper);
    $hashed_password = $hashed_data['hash'];
    $salt = $hashed_data['salt'];

    // Speichere den Benutzer in der Datenbank
    $stmt = $db->prepare("INSERT INTO users (username, password, salt) VALUES (:username, :password, :salt)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':salt', $salt);
    $stmt->execute();

    $stmt2 = $db->prepare("SELECT * FROM users WHERE username = :uname AND password = :hashed");
    $stmt2->bindParam(':uname', $username);
    $stmt2->bindParam(':hashed', $hashed_password);
    $stmt2->execute();
    $result2 = $stmt2->fetchAll();
    $_SESSION["BID"] = $result2[0]["BID"];
    $_SESSION["username"] = $result2[0]["username"];
    echo "<script type='text/javascript'>location.href = './main.php';</script>";
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
                        <form id="signupForm" action="" method="POST">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // 8 wixhars, 1 letter, 1 number
            if (!regex.test(password)) {
                alert('Password must be at least 8 characters long and contain at least one letter and one number.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>