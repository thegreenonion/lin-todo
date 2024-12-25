<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h1 style="text-align: center">Hallo, <?php echo $_SESSION['username']; ?>!</h1>
    <p style="text-align: center">Es ist <?php echo date("H:i") ?> Uhr.</p>
    <br>
    <?php
    include("conn.php");
    include("./control/getListsByID.php");
    $x = 0;
    $y = 0;
    foreach ($result as $row) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ?");
        $stmt->execute([$row['LID']]);
        $count = $stmt->fetch()[0];
        $y += $count;
        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ? AND is_done = 0");
        $stmt->execute([$row['LID']]);
        $ocount = $stmt->fetch()[0];
        $x += $ocount;
    }

    function compareByTimeDesc($a, $b)
    {
        $ta = strtotime($a['due']);
        $tb = strtotime($b['due']);
        if ($ta < $tb) {
            return -1;
        } else if ($ta > $tb) {
            return 1;
        } else {
            return 0;
        }
    }
    ?>
    <h4 style="margin-left: 10px">Schnelle Übersicht:</h4>
    <p style="margin-left: 20px">
        Du hast <span style="color: green"><?php echo count($result); ?></span> Liste(n).
        <br>
        Darin enthalten sind <span><?php echo $y; ?></span> Aufgabe(n).
        <br>
        Davon sind <span style="color: red"><?php echo $x; ?></span> noch nicht erledigt.
        <br>
        <a href="main.php?action=getlists" style="color: lightblue">Zur Übersicht</a>
        <br>
        <br>
        Die nächsten drei Aufgaben sind:

        <?php
        $stmt = $db->prepare("SELECT items.content, items.due, items.iLID FROM lists
        INNER JOIN items ON items.iLID = lists.LID WHERE lists.lBID = ? AND items.is_done = 0");
        $stmt->execute([$_SESSION['BID']]);
        $result = $stmt->fetchAll();
        usort($result, "compareByTimeDesc");

        echo "<table class='table table-bordered' style='width: 500px; margin-left: 20px'>";
        echo "<tr>
        <th>Aufgabe</th>
        <th>Fällig am</th>
        <th>Liste</th>
        </tr>";
        $i = 0;
        foreach ($result as $row) {
            if ($i < 3) {
                $stmt = $db->prepare("SELECT name FROM lists WHERE LID = ?");
                $stmt->execute([$row['iLID']]);
                $listname = $stmt->fetch()[0];
                echo "<tr>";
                echo "<td>" . $row['content'] . "</td>";
                echo "<td>" . $row['due'] . "</td>";
                echo "<td>" . $listname . "</td>";
                echo "</tr>";
                $i++;
            }
        }
        echo "</table>";
        ?>
    </p>
</body>

</html>