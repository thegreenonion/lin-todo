<?php
include("conn.php");
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <h1>Neues Item zu Liste hinzufügen:</h1>
    <form action="control/setitem.php" method="post">
        <label for="content">Name:</label>
        <input type="text" id="content" name="content" required>
        <br>
        <label for="due">Fälligkeitsdatum:</label>
        <input type="date" id="due" name="due" required>
        <br>
        <label for="lid">Liste:</label>
        <select name="lid" id="lid">
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
        <input type="submit" value="Hinzufügen">
    </form>
</body>

</html>