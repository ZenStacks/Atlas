<?php

function encryptData($plaintext){
    $cipher = "AES-256-CBC";
    $key = hex2bin($_ENV['ENCRYPTION_KEY']);
    $iv = random_bytes(openssl_cipher_iv_length($cipher));
    $encrypted = openssl_encrypt(
        $plaintext,
        $cipher,
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );
    return base64_encode($iv . $encrypted);
}
function decryptData($ciphertext){
    $cipher = "AES-256-CBC";
    $key = hex2bin($_ENV['ENCRYPTION_KEY']);
    $data = base64_decode($ciphertext);
    $ivLength = openssl_cipher_iv_length($cipher);
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