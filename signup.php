<?php
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

function hashPassword($password, $pepper) {
    $salt = bin2hex(random_bytes(16));
    $hashed_password = hash('sha256', $salt . $password . $pepper);
    return ['hash' => $hashed_password, 'salt' => $salt];
}

function process_form(): bool {
    global $db, $pepper;

    $username = $_POST['username'];
    $password = $_POST['password'];

  // Hash the password
  $pepper = "yoxxxxxxx45hghjkj"; // Define your pepper string
  $hashed_password_data = hashPassword($password, $pepper);
  $hashed_password = $hashed_password_data['hash'];
  $salt = $hashed_password_data['salt'];

  // Prepare and bind
  $stmt = $db->prepare("INSERT INTO users (username, password, salt) VALUES (?, ?, ?)");
  $stmt->bindParam(1, $username);
  $stmt->bindParam(2, $hashed_password);
  $stmt->bindParam(3, $salt);

  // Execute the statement
  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $stmt->error;
  }
  return false;
}

if($_SERVER["REQUEST_METHOD"]== "POST")
{
  process_form();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <h2>Signup</h2>
  <form method="post" action="">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Signup</button>
  </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>