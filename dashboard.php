<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Hallo, <?php echo $_SESSION['username'];?>!</h1>
    <p style="text-align: center">Es ist <?php echo date("H:i") ?> Uhr.</p>
</body>
</html>