<?php

function create_list($BID, string $title)
{
    // create connection to database
    include("./conn.php");

    // send creation query of list to database    
    try {
        $sql = "INSERT INTO `lists` (`name`, `lBID`) VALUES (?, ?);";
        $statement = $db->prepare($sql);
        $statement->execute([$title, $BID]);
    } catch (Exception $e) {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }
    echo "<script>window.location.href='main.php?action=getlists'</script>";
}
?>
<html>

<body>
    <h1>Erstellen einer neuen Liste für <?php echo "<span style='color: cream'>" . $_SESSION["username"] . "</span>";?></h1>

    <?php
    if (isset($_POST['title'])) {
        $list_title = $_POST['title'];
        $BID = $_SESSION['BID'];

        create_list($BID, $list_title);
    }
    ?>
    <form method='post' action="">
        <input type="text" name="title">
        <input type="submit" value="Erstellen" style="background-color: #007bff; border-color: #007bff;">
    </form>

</body>

</html>