<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Geteilte Liste</title>
    <link rel="stylesheet" href="path/to/your/css/file.css">
</head>
<body>
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
    echo "<h1>Inhalt der geteilten Liste \"$lname\":</h1>";
    echo "<p style='text-align: center'>Inhalt der Liste \"$lname\":</p>";
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Zu erledigen bis</th>';
    echo '<th>Status</th>';
    echo '</tr>';
    echo '</thead>';
    foreach($result as $row)
    {
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['content']) . '</td>';
        echo '<td>' . htmlspecialchars($row['due']) . '</td>';
        echo '<td>' . ($row['is_done'] ? 'Erledigt' : 'Nicht erledigt') . '</td>';
        echo '</tr>';
        echo '</tbody>';
    }
    echo '</table>';
    ?>
</body>
</html>