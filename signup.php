<?php
include 'Hash.php';

$datenbank = "eulbert_gtodo";
$host = "localhost";
$user = "hwalde";
$passwd = "UG2aepai4g";
$recaptchaSecret = 'YOUR_SECRET_KEY'; // Add your reCAPTCHA secret key here

// Datenbankverbindung herstellen
try {
  $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Datenbankverbindung gescheitert: " . $e->getMessage());
}

function signup($db, $username, $password)
{
  $pepper = 'yoxxxxxxx45hghjkj';
  $hash = hashPassword($password, $pepper);
  $stmt = $db->prepare("INSERT INTO users (username, password, salt) VALUES (:username, :password, :salt)");
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $hash['hash']);
  $stmt->bindParam(':salt', $hash['salt']);
  $stmt->execute();
  $_SESSION['username'] = $username;
  $stmt = $db->prepare("SELECT BID FROM users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch();
  $_SESSION['BID'] = $user['BID'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  signup($db, $username, $password);
  echo '<script>window.location.href = "main.php";</script>';
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
</head>

<body>
  <div class="container">
    <h2>Signup</h2>
    <form id="demo-form" method="post" action="">
      <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="g-recaptcha" data-sitekey="6LeWEGQqAAAAAD16sO6r8hIFmQ_OnY8M9fzxtfKt" data-callback="enableSignupButton"></div>
      <button type="submit" class="btn btn-success" id="signup-button" disabled style="background-color: #007bff; border-color: #007bff;">Signup</button>
    </form>
  </div>
  <script>
    function enableSignupButton() {
      document.getElementById('signup-button').disabled = false;
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>