<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Listen von Benutzer</title>
</head>
<body>
    <h1 class="text-center">Listen von <?php echo "<span style='color: blue;'>$_SESSION[username]</span>"; ?></h1>
    <?php
    include("conn.php");
    include("./control/getListsByID.php");
    echo "<div class='container mt-5'>";
    echo "<table class='table table-bordered'>";
    echo "<thead class='thead-dark'><tr><th>Name</th><th>Anzahl Aufgaben</th><th>Davon unerledigt</th><th>Löschen</th></tr></thead>";
    echo "<tbody>";
    foreach($result as $row)
    {
        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ?");
        $stmt->execute([$row['LID']]);
        $count = $stmt->fetch()[0];
        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ? AND is_done = 0");
        $stmt->execute([$row['LID']]);
        $ocount = $stmt->fetch()[0];
        $cmd = "window.location.href='main.php?action=deletelist&lid=" . $row["LID"] . "'";
        echo "<tr>
        <td>
            <a href='main.php?action=getitems&lid=$row[LID]'>$row[name]</a>
        </td>
        <td>$count</td>
        <td>
            <span style='color: red'>$ocount</span>
        </td>
        <td>
            <button onclick=$cmd class='btn btn-danger'>Löschen</button>
        </td>
        </tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    ?>
</body>
</html>