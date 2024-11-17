<?php
// create db connection
include("../conn.php");

function requestSharedUsers($db, int $LID)
{
    try {
        $sql = "SELECT U.username, U.BID FROM users U, darfsehen D WHERE U.BID = D.dBID AND dLID=?";
        $statement = $db->prepare($sql);
        $statement->execute([$LID]);
    } catch (Exception $e) {
        die("Laden der Übersicht gescheitert: " . $e->getMessage());
    }

    $result = $statement->fetchAll();

    return $result;
}

function createTable(array $queryresult)
{
    if (empty($queryresult)) {
        echo "Die Liste wird mit keinen Benutzern geteilt.";
        return;
    }

    echo "
        <table class='table table-bordered'>
            <tr>
                <th>Benutzer</th>
                <th>Entfernen</th>
            </tr>
        ";

    foreach ($queryresult as $row) {
        echo "
            <tr>
                <td>" . $row['username'] . "</td>
                <td>
                    <form action='' method='post'>
                        <input type='hidden' name='BID' value='" . $row['BID'] . "'>
                        <input class='btn btn-danger' type='submit' value='Entfernen'>
                    </form>
                </td>
            </tr>
        ";
    }

    echo "</table>";
}

function removeUser($db, int $BID, int $LID)
{
    try {
        $statement = $db->prepare("DELETE FROM darfsehen d WHERE d.dBID=? AND d.dLID=?");
        $statement->execute([$BID, $LID]);
    } catch (Exception $e) {
        die("Löschen fehlgeschlagen: " . $e->getMessage());
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

    <!-- Form to select a list and display all users that have access to it -->
    <form method="post" action="">

        <!-- Selection of the wanted list with a dropdown-list of all shared lists -->
        <select style="width: 150px; margin-left: 20px" class="form-select" name="LID" id="list-selection">
            <?php
            // request all owned lists
            $statement = $db->prepare("SELECT LID, name FROM lists WHERE lBID=?");
            $statement->execute([$_SESSION['BID']]);
            $result = $statement->fetchAll();

            $stmt2 = $db->prepare("SELECT * FROM darfsehen WHERE dLID = ?");

            // create dropdown-list with all shared lists
            foreach ($result as $row) {
                $stmt2->execute([$row['LID']]);
                
                if ($stmt2->rowCount() == 0) {
                    continue;
                }
                
                $name = $row['name'];
                echo "
                    <option value='" . $row['LID'] . "'>" . $row['name'] . "</option>
                ";
            }
            ?>
        </select>
        <br>

        <input class="btn btn-info" style="margin-left: 20px" type="submit" value="Liste auswählen">
    </form>

    <?php
    if (isset($_POST['LID'])) {
        $LID = $_POST['LID'];
        $_SESSION['LID'] = $LID;

        $result = requestSharedUsers($db, $LID);
        echo "<br>";
        createTable($result);
    }

    if (isset($_POST['BID'])) {
        $BID = $_POST['BID'];
        removeUser($db, $BID, $_SESSION['LID']);
    }

    if (isset($_SESSION['LID']) && !isset($_POST['LID'])) {
        $LID = $_SESSION['LID'];
        $result = requestSharedUsers($db, $LID);
        echo "<br>";
        echo "<h2 style='margin-left: 20px; color: cream'>Benutzer, mit denen \"" . $name . "\" geteilt wird:</h2>";
        createTable($result);
    }
    ?>
</body>

</html>