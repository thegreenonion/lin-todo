<?php
// Create connection to db
include("../conn.php");

function FindBIDByUsername($db, string $username): int
{
    // Finds and returns the BID (user ID) for a given username from the database

    $sql = "SELECT username, BID FROM users WHERE username=?";
    $statement = $db->prepare($sql);
    $statement->execute([$username]);
    $result = $statement->fetch();

    // if not found, then return -1
    if ($result == 0) {
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

    if (count($result) == 0) {
        die("Dieser Benutzer befindet sich schon in der ausgewählten Liste.");
    }

    // Inserts a new record into the 'darfsehen' table with provided IDs to add a user
    try {
        $statement = $db->prepare("INSERT INTO darfsehen (dLID, dBID) VALUES (?, ?)");
        $statement->execute([$LID, $foreign_BID]);
        ;
    } catch (Exception $e) {
        die("Eintragung gescheitert: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        input {
            margin: 10px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    if (isset($_POST['username']) && isset($_POST['LID'])) {
        $foreign_username = $_POST['username'];
        $foreign_user_BID = FindBIDByUsername($db, $foreign_username);
        $LID = $_POST['LID'];

        if ($foreign_user_BID == -1) {
            echo "Falscher Benutzername";
        } else {
            // add user to database
            AddUser($db, $foreign_user_BID, $LID);
        }

    }
    ?>

    <form action="" method="post" class="container mt-5"
        style="border: 2px solid #000; padding: 20px; background-color: #333; color: #fff; border-radius: 15px;">
        <div class="mb-3">
            <label for="LID" class="form-label">Liste auswählen:</label>
            <select name="LID" class="form-select">
                <?php
                $stmt = $db->prepare("SELECT * FROM lists WHERE lBID = " . $_SESSION['BID'] . ";");
                $stmt->execute();
                $result = $stmt->fetchAll();

                foreach ($result as $row) {
                    $lid = $row["LID"];
                    $name = $row["name"];
                    echo "<option value=\"$lid\">$name</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Teilen mit:</label>
            <input type="text" name="username" class="form-control" placeholder="Benutzername">
        </div>

        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Benutzer
            hinzufügen</button>
    </form>
</body>

</html>