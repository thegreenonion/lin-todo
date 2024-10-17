<?php
session_start();

include("../conn.php");

function FindBIDByUsername(String $username): int
{
    $sql = "SELECT username, BID FROM users WHERE username=?";
    $statement = $db->prepare($sql);
    $statement->excecute([$username]);
    $statement->fetch();

    $BID = $statement['BID'];

    echo $username; echo $BID;

    return $BID;
}

function AddUser(String $foreign_username, int $LID)
{
    $foreign_BID = FindBIDByUsername($foreign_username);


    
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
    if(isset($_POST['user']))
    {
        $foreign_username = $_POST['user'];
        
        // add user to database
        AddUser($foreign_username, 1);
    }
    ?>
    <form action="" method="post">
        <select name="user">
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

        <select name="list">
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

        <input type="submit" value="Benutzer hinzufügen">
    </form>
</body>
</html>