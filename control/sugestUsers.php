<?php
include("../conn.php");

$query = $_GET['query'];

$sql = $db->prepare("SELECT username FROM users WHERE username LIKE ?");
$sql->execute(["%$query%"]);
$results = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
