<?php
$datenbank = "eulbert_gtodo";
$host = "localhost";
$user = "hwalde";
$passwd = "UG2aepai4g";

// Datenbankverbindung herstellen
try 
{
    $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) 
{
    die("Datenbankverbindung gescheitert: " . $e->getMessage());
}
?>