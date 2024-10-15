<?php
include("./conn.php");
$lid = $_SESSION["lid"];
$iid = $_SESSION["IID"];
$stmt = $db->prepare("DELETE FROM items WHERE IID = ?");
$stmt->execute([$iid]);
unset($_SESSION["IID"]);
echo "<script>window.location.href='./main.php?action=getitems&lid=$lid'</script>";
?>