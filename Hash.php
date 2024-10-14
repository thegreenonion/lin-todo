<?php
$pepper = 'your_pepper_string';

function hashPassword($password, $pepper) {
    $salt = bin2hex(random_bytes(22));
    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = password_hash($peppered_password . $salt, PASSWORD_BCRYPT);
    return ['hash' => $hashed_password, 'salt' => $salt];
}

function verifyPassword($password, $stored_hash, $stored_salt, $pepper) {
    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $combined_password = $peppered_password . $stored_salt;
    return password_verify($combined_password, $stored_hash);
}
?>