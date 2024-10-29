<?php
include("../conn.php");
$stmt = $db->prepare("INSERT INTO items (content, due, is_done, iLID) VALUES (?, ?, ?, ?)");
$stmt->execute([$_POST['content'], $_POST['due'], 0, $_POST['lid']]);
$lid = $_POST['lid'];
echo "<script>window.location.href='../main.php?action=getitems&lid=$lid'</script>";
?>