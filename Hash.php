<?php
function hashPassword(String $password, String $pepper): array
{
    $salt = bin2hex(random_bytes(22));

    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = hash_hmac("sha256", $peppered_password, $salt);

    return ['hash' => $hashed_password, 'salt' => $salt];
}

function verifyPassword(String $password, String $stored_hash, String $stored_salt, String $pepper): array 
{
    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = hash_hmac("sha256", $peppered_password, $stored_salt);

    // verify password and return array with bool + hashed_password
    if ($hashed_password != $stored_hash)
    {
        return ['hashesMatch' => FALSE, 'hashed_password' => NULL];
    }

    return ['hashesMatch' => TRUE, 'hashed_password' => $hashed_password];
}
