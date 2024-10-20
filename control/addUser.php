<?php
session_start();

// Create connection to db
include("../conn.php");

function AddUser($db, int $foreign_BID, int $LID)
{
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
    <title>Document</title>
</head>
<body>    
    <?php
    if(isset($_POST['user_BID']) && isset($_POST['LID']))
    {
        $foreign_user_BID = $_POST['user_BID'];
        $LID = $_POST['LID'];

        // add user to database
        AddUser($db, $foreign_user_BID, $LID);
    }
    ?>

    <form action="" method="post">
        
        <select name="user_BID">
            <?php
            $stmt = $db->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $row) {
                
                if($row["BID"] == $_SESSION["BID"]) {
                    continue;
                }
                
                $bid = $row["BID"];
                $name = $row["username"];
                echo "<option value=$bid>$name</option>";
            }
            ?>
        </select>

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