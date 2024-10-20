<?php
$uid = $_SESSION["BID"];
$sql = "SELECT * FROM lists WHERE lBID = ? ORDER BY name asc";
$stmt = $db->prepare($sql);
$stmt->execute([$uid]);
$result = $stmt->fetchAll();
?>