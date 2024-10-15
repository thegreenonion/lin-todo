<?php 
session_start();

$BID = $_SESSION['BID'];

function create_list($BID, String $title)
{
    // create connection to database
    include('conn.php');

    // send creation query of list to database    
    try
    {
        $sql = "INSERT INTO INSERT INTO `lists` (`LID`, `name`, `lBID`) VALUES (?, ?, ?);";
        $statement = $db->prepare($sql);
        $statement->execute([NULL, $title, $BID]);
    }
    catch(Exception $e)
    {
        die("Loginvorgang gescheitert: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listenerstellung</title>
</head>
<body>
    <h1>Hallo <?php echo $_SESSION['BID']; echo $_SESSION['username'];?></h1>
    <h1>Erstellen einer Liste</h1>

    <?php
    if(isset($_POST['title']))
        {
            $list_title = $_POST['title'];
            
            create_list($BID, $list_title);
        }
    ?>
    <form methode='post'>
        <input type="text" name="title">
        <input type="submit" value="Erstellen">
    </form>

</body>
</html>