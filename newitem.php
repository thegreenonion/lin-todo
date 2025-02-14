<?php
include("conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css">

<body>
    <h1>Neues Item zu Liste hinzufügen:</h1>
    <?php
    $sql = "SELECT * FROM lists WHERE lBID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION["BID"]]);
    $result = $stmt->fetchAll();
    if(count($result) == 0){
        echo "<h2 style='color: red'>Zuerst Liste erstellen</h2>";
        echo "<a style='color: cream; font-size: 20px' href='main.php?action=newlist'>Liste erstellen</a>";
        die();
    }
    ?>
    <form action="control/setitem.php" method="post">
        <label for="content">Name:</label>
        <input type="text" id="content" name="content" required>
        <br>
        <label for="due">Fälligkeitsdatum:</label>
        <input type="date" id="due" name="due" required>
        <br>
        <label for="lid">Liste:</label>
        <select name="lid" id="lid" required>
            <?php
            $sql = "SELECT * FROM lists WHERE lBID = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_SESSION["BID"]]);
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $lid = $row["LID"];
                $name = $row["name"];
                echo "<option value=$lid>$name</option>";
            }
            ?>
        </select>
        <button type="submit" style="background-color: #f0707; color: white;">Hinzufügen</button>
    </form>
</body>

</html>