<?php
include("./conn.php");
$lid = $_SESSION["lid"];
$stmt = $db->prepare("DELETE FROM lists WHERE LID = ?");
$stmt->execute([$lid]);
unset($_SESSION["lid"]);
echo "<script>window.location.href='./main.php?action=getlists'</script>";
?>