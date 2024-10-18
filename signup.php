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
  $statemnt = $db->prepare("SELECT BID FROM users WHERE username = :username");
  $statemnt->bindParam(':username', $username);
  $statemnt->execute();
  $user = $statemnt->fetch();
  $_SESSION['BID'] = $user['BID'];
}

function verifyCaptcha($captchaToken)
{
  $secretKey = "6LeWEGQqAAAAAAKTOR0JhGtyDAWVmTqQiQXHSn9K";  // Ersetze durch deinen Secret Key
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $data = array('secret' => $secretKey, 'response' => $captchaToken);
  
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data),
    ),
  );
  
  $context  = stream_context_create($options);
  $response = file_get_contents($url, false, $context);
  if ($response === FALSE) {
    return null;
  }
  return json_decode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $captchaToken = $_POST['g-recaptcha-response']; // Hol dir den reCAPTCHA-Token

  // Verifiziere das reCAPTCHA
  $captchaResponse = verifyCaptcha($captchaToken);
}
?>
<!DOCTYPE html>
<html lang="en">
<html></head>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
      <button type="submit" class="btn btn-primary" id="signup-button" disabled>Signup</button>
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
</body>
</html>