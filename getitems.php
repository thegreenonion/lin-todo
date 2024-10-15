<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center">Aufgaben von <?php echo $_SESSION["username"]; ?></h1>
    <?php
    include("conn.php");
    $lid = $_SESSION['lid'];
    $stmt = $db->prepare("SELECT * FROM items INNER JOIN lists ON lists.LID = items.iLID WHERE iLID = ?");
    $stmt->execute([$lid]);
    $result = $stmt->fetchAll();
    if(count($result) == 0)
    {
        echo "<p>Keine items vorhanden</p>";
        return;
    }
    $lname = $result[0]['name'];
    echo "<p style='text-align: center'>Inhalt der Liste \"$lname\":</p>";
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Zu erledigen bis</th>';
    echo '<th>Status</th>';
    echo '<th>Erledigen</th>';
    echo '<th>Löschen</th>';
    echo '</tr>';
    echo '</thead>';
    foreach($result as $row)
    {
        $command = "window.location.href='main.php?action=edititem&iid=" . $row['IID'] . "'";
        $command2 = "window.location.href='main.php?action=deleteitem&iid=" . $row['IID'] . "'";
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['content']) . '</td>';
        echo '<td>' . htmlspecialchars($row['due']) . '</td>';
        echo '<td>' . ($row['is_done'] ? 'Erledigt' : 'Nicht erledigt') . '</td>';
        if($row["is_done"] == 0)
        {
            echo "<td><button onclick=\"$command\" class='btn btn-success'>Erledigt</button></td>";
        }
        else {
            echo "<td></td>";
        }
        echo "<td><button onclick=\"$command2\" class='btn btn-danger'>Löschen</button></td>";
        echo '</tr>';
        echo '</tbody>';
    }
    echo '</table>';
    ?>
</body>
</html>