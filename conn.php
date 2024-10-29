<?php
$datenbank = getenv("DB");
$host = "localhost";
$user = getenv("DBUSER");
$passwd = getenv("DBPASS");

// Datenbankverbindung herstellen
try {
    $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindung gescheitert: " . $e->getMessage());
}