<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        p {
            margin-left: 10px;
        }
        button {
            margin-left: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Listen von <?php echo "<span style='color: cream;'>$_SESSION[username]</span>"; ?></h1>
    <?php
    echo "<h2>Deine Listen:</h2>";
    include("conn.php");
    include("./control/getListsByID.php");
    if(count($result) == 0) {
        $cmd = "window.location.href='main.php?action=newlist'";
        echo "<p style='color: red; font-weight: bold'>Keine Listen vorhanden.</p>";
        echo "<button class='btn btn-success' onclick=$cmd>Neue Liste erstellen</button>";
    }
    else {
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
    }

    echo "<h2>Freigegebene Listen:</h2>";
    $bid = $_SESSION["BID"];
    $stmt = $db->prepare("SELECT * FROM darfsehen WHERE dBID = ?");
    $stmt->execute([$bid]);
    $result = $stmt->fetchAll();
    if(count($result) == 0) {
        echo "<p style='color: red; font-weight: bold'>Keine Listen vorhanden.</p>";
    }
    else {
        echo "<div class='container mt-5'>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='thead-dark'><tr><th>Name</th><th>Anzahl Aufgaben</th><th>Davon unerledigt</th></tr></thead>";
        echo "<tbody>";
        foreach($result as $row)
        {
            $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ?");
            $stmt->execute([$row['dLID']]);
            $count = $stmt->fetch()[0];
            $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ? AND is_done = 0");
            $stmt->execute([$row['dLID']]);
            $ocount = $stmt->fetch()[0];
            $stmt = $db->prepare("SELECT * FROM lists WHERE LID = ?");
            $stmt->execute([$row["dLID"]]);
            $result2 = $stmt->fetch();
            echo "<tr>
            <td>
                <a href='main.php?action=getitems&lid=$row[dLID]'>$result2[name]</a>
            </td>
            <td>$count</td>
            <td>
                <span style='color: red'>$ocount</span>
            </td>
            </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    ?>
</body>
</html>