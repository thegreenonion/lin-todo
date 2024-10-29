<?php
include("vars/db.php");
include("vars/dbuser.php");
include("vars/dbpass.php");
$datenbank = $dbn;
$host = "localhost";
$user = $dbuser;
$passwd = $dbpass;

// Datenbankverbindung herstellen
try {
    $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindung gescheitert: " . $e->getMessage());
}