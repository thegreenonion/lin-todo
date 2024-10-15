<?php 
session_start();

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
