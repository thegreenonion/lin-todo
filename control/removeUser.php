<?php
session_start();

// create db connection
include("../conn.php");

function requestSharedUsers($db, int $LID)
{
    try
    {
        $sql = "SELECT U.username, U.BID FROM users U, darfsehen D WHERE U.BID = D.dBID AND dLID=?";
        $statement = $db->prepare($sql);
        $statement->execute([$LID]);
    } 
    catch (Exception $e) 
    {
        die("Laden der Übersicht gescheitert: " . $e->getMessage());
    }

    $result = $statement->fetchAll();
    
    return $result;
}

function createTable($queryresult)
{
    echo "
        <table>
            <tr>
                <th>User</th>
                <th>Entfernen</th>
            </tr>
        ";

    foreach ($queryresult as $row)
    {
        echo "
            <tr>
                <td>". $row['username'] ."</td>
                <td></td>
            </tr>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entfernen von Benutzer</title>
</head>
<body>
    <?php 
    $result = requestSharedUsers($db, 2);
    createTable($result);
    ?>
</body>
</html>