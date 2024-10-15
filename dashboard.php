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
    <br>
    <?php
    include("conn.php");
    include("./control/getListsByID.php");
    $x = 0;
    $y = 0;
    foreach($result as $row)
    {
        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ?");
        $stmt->execute([$row['LID']]);
        $count = $stmt->fetch()[0];
        $y += $count;
        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ? AND is_done = 0");
        $stmt->execute([$row['LID']]);
        $ocount = $stmt->fetch()[0];
        $x += $ocount;
    }
    ?>
    <h4>Schnelle Übersicht:</h4>
    <p>
        Du hast <span style="color: green"><?php echo count($result); ?></span> Liste(n).
        <br>
        Darin enthalten sind <span><?php echo $y; ?></span> Aufgabe(n).
        <br>
        Davon sind <span style="color: red"><?php echo $x; ?></span> noch nicht erledigt.
        <br>
        <a href="main.php?action=getlists">Zur Übersicht</a>
    </p>
    <p></p>
</body>
</html>