<?php
/**
 * Hashes a password using a provided pepper and a randomly generated salt
 *
 * parameters:
 * - $password: The password to be hashed
 * - $pepper: A secret value used to enhance the security of the hash
 * 
 * return value: array with
 * - 'hash': The hashed password.
 * - 'salt': The randomly generated salt.
 */
function hashPassword(string $password, string $pepper): array
{
    $salt = bin2hex(random_bytes(22));

    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = hash_hmac("sha256", $peppered_password, $salt);

    return ['hash' => $hashed_password, 'salt' => $salt];
}

/**
 * Verifies a password against a stored hash using a hasing with a salt and a pepper
 * 
 * parameters:
 * - $password: The plain text password to verify
 * - $stored_hash: The stored hash to compare against
 * - $stored_salt: The salt used in the stored hash
 * - $pepper: The pepper used to hash the password
 * 
 * return value:
 * - bool: Returns TRUE if the password is verified, FALSE otherwise.
 */
function verifyPassword(string $password, string $stored_hash, string $stored_salt, string $pepper): bool
{
    $peppered_password = hash_hmac("sha256", $password, $pepper);
    $hashed_password = hash_hmac("sha256", $peppered_password, $stored_salt);

    // check if the hashes match
    if ($hashed_password != $stored_hash) {
        return FALSE; 
    }

    return TRUE;
}
