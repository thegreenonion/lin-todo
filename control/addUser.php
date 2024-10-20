<?php
session_start();

// Create connection to db
include("../conn.php");

function FindBIDByUsername($db, String $username): int
{
    // Finds and returns the BID (user ID) for a given username from the database

    $sql = "SELECT username, BID FROM users WHERE username=?";
    $statement = $db->prepare($sql);
    $statement->execute([$username]);
    $result = $statement->fetch();

    // if not found, then return -1
    if ($result == 0)
    {
        return -1; 
    }
    
    $BID = $result['BID'];

    return $BID;
}

function AddUser($db, int $foreign_BID, int $LID)
{
    // Checks if a user is already in the list by querying the database with given IDs and terminates if found.
    $statement = $db->prepare("SELECT dLID, dBID FROM darfsehen WHERE dLID=? AND dBID=?");
    $statement->execute([$LID, $foreign_BID]);
    $result = $statement->fetch();

    if(count($result) != 0)
    {
        die("Dieser Benutzer befindet sich schon in der ausgewählten Liste.");
    }

    // Inserts a new record into the 'darfsehen' table with provided IDs to add a user
    try
    {
        $statement = $db->prepare("INSERT INTO darfsehen (dLID, dBID) VALUES (?, ?)");
        $statement->execute([$LID,$foreign_BID]);;
    }
    catch(Exception $e)
    {
        die("Eintragung gescheitert: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer hinzufügen</title>
</head>
<body>    
    <?php
    if(isset($_POST['username']) && isset($_POST['LID']))
    {
        $foreign_username = $_POST['username'];
        $foreign_user_BID = FindBIDByUsername($db, $foreign_username);
        $LID = $_POST['LID'];

        if($foreign_user_BID == -1)
        {
            echo "Falscher Benutzername";
        } 
        else
        {
            // add user to database
            AddUser($db, $foreign_user_BID, $LID);
        }
        
    }
    ?>

    <form action="" method="post">
        
        <input type="text" name="username" placeholder="Benutzername">

        <select name="LID">
            <?php
            $stmt = $db->prepare("SELECT * FROM lists WHERE lBID = ". $_SESSION['BID'] .";");
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row) {
                $lid = $row["LID"];
                $name = $row["name"];
                echo "<option value=$lid>$name</option>";
            }
            ?>
        </select>

        <input type="submit" value="Benutzer hinzufügen">
    </form>
</body>
</html>