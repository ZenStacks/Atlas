<?php

function getEncryptionKey()
{
    if (empty($_ENV['ENCRYPTION_KEY'])) {
        throw new Exception("ENCRYPTION_KEY is not configured.");
    }

    $key = hex2bin($_ENV['ENCRYPTION_KEY']);

    if ($key === false || strlen($key) !== 32) {
        throw new Exception("ENCRYPTION_KEY must be a 64-character hexadecimal string.");
    }

    return $key;
}

function encryptData($plaintext)
{
    $cipher = "AES-256-CBC";
    $key = getEncryptionKey();

    $ivLength = openssl_cipher_iv_length($cipher);
    $iv = random_bytes($ivLength);

    $encrypted = openssl_encrypt(
        $plaintext,
        $cipher,
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    if ($encrypted === false) {
        throw new Exception("Encryption failed.");
    }

    return base64_encode($iv . $encrypted);
}

function decryptData($ciphertext)
{
    $cipher = "AES-256-CBC";
    $key = getEncryptionKey();

    $data = base64_decode($ciphertext, true);

    if ($data === false) {
        return false;
    }

    $ivLength = openssl_cipher_iv_length($cipher);
    if (strlen($data) < $ivLength) {
        return false;
    }

    $iv = substr($data, 0, $ivLength);
    $encrypted = substr($data, $ivLength);

    return openssl_decrypt(
        $encrypted,
        $cipher,
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );
}
?>