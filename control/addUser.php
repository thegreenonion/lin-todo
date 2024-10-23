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

    <form action="" method="post" class="container mt-5" style="border: 2px solid #000; padding: 20px; background-color: #333; color: #fff; border-radius: 15px;">
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
            <input type="text" name="username" id="username" class="form-control" placeholder="Benutzername" onkeyup="suggestUsers(this.value)">
            <div id="suggestions" style="background-color: #fff; border: 1px solid #ccc; display: none; position: absolute; z-index: 1000;"></div>
        </div>

        <script>
            function suggestUsers(query) {
            if (query.length == 0) {
                document.getElementById('suggestions').style.display = 'none';
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                const suggestions = JSON.parse(this.responseText);
                let suggestionBox = document.getElementById('suggestions');
                suggestionBox.innerHTML = '';
                suggestions.forEach(function(user) {
                    let div = document.createElement('div');
                    div.innerHTML = user.username;
                    div.style.padding = '10px';
                    div.style.cursor = 'pointer';
                    div.onclick = function() {
                    document.getElementById('username').value = user.username;
                    suggestionBox.style.display = 'none';
                    };
                    suggestionBox.appendChild(div);
                });
                suggestionBox.style.display = 'block';
                }
            };
            xhr.open("GET", "suggestUsers.php?query=" + query, true);
            xhr.send();
            }
        </script>

        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Benutzer hinzufügen</button>
    </form>
</body>

</html>