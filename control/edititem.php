<?php
include("./conn.php");
$lid = $_SESSION["lid"];
$iid = $_SESSION["IID"];
$stmt = $db->prepare("UPDATE items SET is_done = 1 WHERE IID = ?");
$stmt->execute([$iid]);
unset($_SESSION["IID"]);
echo "<script>window.location.href='./main.php?action=getitems&lid=$lid'</script>";
?>