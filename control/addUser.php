<?php
include "../conn.php";


function FindBIDByUsername($db, string $username): int
{
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
    // Check if the user already has access to the list
    $statement = $db->prepare("SELECT dLID, dBID FROM darfsehen WHERE dLID=? AND dBID=?");
    $statement->execute([$LID, $foreign_BID]);
    $result = $statement->fetch();

    if ($result) {
        echo "Der Benutzer hat bereits Zugriff auf die Liste.";
        return;
    }

    // Check if the LID exists in the lists table
    $statement = $db->prepare("SELECT LID FROM lists WHERE LID=?");
    $statement->execute([$LID]);
    $result = $statement->fetch();

    if (!$result) {
        echo "Die Liste existiert nicht.";
        return;
    }

    // Check if owner of the list is trying to add themselves
    $statement = $db->prepare("SELECT lBID FROM lists WHERE LID=:LID");
    $statement->execute([':LID' => $LID]);
    $result = $statement->fetch();

    if ($result['lBID'] == $foreign_BID) {
        echo "Du kannst dich nicht selbst hinzufügen.";
        return;
    }

    $statement = $db->prepare("INSERT INTO darfsehen (dLID, dBID) VALUES (?, ?)");
    $statement->execute([$LID, $foreign_BID]);
    echo "Benutzer zu Liste hinzugefügt!";
}

function GetUserLists($db, $userID)
{
    $sql = "SELECT LID, name FROM lists WHERE lBID=?";
    $statement = $db->prepare($sql);
    $statement->execute([$userID]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

$userID = $_SESSION['BID'];
$lists = GetUserLists($db, $userID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $LID = $_POST['LID'];

    $foreign_BID = FindBIDByUsername($db, $username);
    if ($foreign_BID === -1) {
        echo "Username not found.";
    } else {
        AddUser($db, $foreign_BID, $LID);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste an Benutzer freigeben</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    #suggestions {
        background-color: #495057;
        border: 1px solid #6c757d;
        color: #ffffff;
        max-height: 150px;
        overflow-y: auto;
        display: none;
    }

    #suggestions div {
        padding: 8px;
        cursor: pointer;
    }

    #suggestions div:hover {
        background-color: #6c757d;
    }
</style>

<body>
    <div class="container mt-5">
        <h1>Liste an Benutzer freigeben</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Benutzername:</label>
                <input type="text" class="form-control" id="username" name="username"
                    onkeyup="suggestUsers(this.value)">
                <div id="suggestions"></div>
            </div>
            <div class="mb-3">
                <label for="LID" class="form-label">Liste auswählen:</label>
                <select class="form-select" id="LID" name="LID">
                    <?php foreach ($lists as $list): ?>
                        <option value="<?= $list['LID'] ?>"><?= htmlspecialchars($list['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Liste freigeben</button>
        </form>
    </div>

    <script>
        function suggestUsers(query) {
            if (query.length == 0) {
                document.getElementById('suggestions').style.display = 'none';
                return;
            }

            $.ajax({
                url: 'https://hmbldtw.spdns.org/~tsuskov/web/lin-todo/control/sugestUsers.php',
                type: 'GET',
                data: { query: query },
                success: function (response) {
                    try {
                        const suggestions = JSON.parse(response);
                        let suggestionBox = document.getElementById('suggestions');
                        suggestionBox.innerHTML = '';
                        suggestions.forEach(function (user) {
                            let div = document.createElement('div');
                            div.innerHTML = user.username;
                            div.onclick = function () {
                                document.getElementById('username').value = user.username;
                                suggestionBox.style.display = 'none';
                            };
                            suggestionBox.appendChild(div);
                        });
                        suggestionBox.style.display = 'block';
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        console.log("Response:", response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error in AJAX call:", status, error);
                }
            });
        }
    </script>
</body>

</html>