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

function createTable(array $queryresult)
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
                <td>
                    <form action='' method='post'>
                        <input type='hidden' name='BID' value='". $row['BID'] ."'>
                        <input type='submit' value='Entfernen'>
                    </form>
                </td>
            </tr>
        ";
    }

    echo "</table>";
}

function removeUser($db, int $BID, int $LID)
{
    try
    {
        $statement = $db->prepare("DELETE FROM darfsehen d WHERE d.dBID=? AND d.dLID=?");
        $statement->execute([$BID, $LID]);
    }
    catch (Exception $e)
    {
        die("Löschen fehlgeschlagen: ". $e->getMessage());
    }

    echo "Erfolgreich entfernt.";
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

    <form method="post" action="">

        <!-- Selection of the list with a dropdown-list of all owned lists -->
        <select name="LID" id="list-selection">
            <?php
            // request all owned lists
            $statement = $db->prepare("SELECT LID, name FROM lists WHERE lBID=?");
            $statement->execute([$_SESSION['BID']]);
            $result = $statement->fetchAll();

            foreach ($result as $row){
                echo "
                    <option value='". $row['LID'] ."'>". $row['name'] ."</option>
                ";
            }
            ?>
        </select>  
        
        <input type="submit" value="Liste auswählen">
    </form>
    
    <?php
    if (isset($_POST['LID']))
    {
        $LID = $_POST['LID'];
        $_SESSION['LID'] = $LID;

        $result = requestSharedUsers($db, $LID);
        createTable($result, $LID);
    }

    if (isset($_POST['BID']))
    {
        $BID = $_POST['BID'];
        removeUser($db, $BID, $_SESSION['LID']);
    }
    ?>   
</body>
</html>