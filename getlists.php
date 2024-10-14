<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Listen von Benutzer</title>
</head>
<body>
    <?php
        include "conn.php";
        $username = $_SESSION["username"];
    ?>
    <h1 class="text-center">Listen von <?php echo "<span style='color: blue;'>$username</span>"; ?></h1>
    
</body>
</html>