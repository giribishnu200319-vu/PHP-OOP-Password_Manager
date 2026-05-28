<?php

class Encryption {

    public static function encrypt($plainText, $key) {

        $iv = substr(hash('sha256', $key), 0, 16);

        return openssl_encrypt(
            $plainText,
            'AES-256-CBC',
            $key,
            0,
            $iv
        );
    }

    public static function decrypt($encryptedText, $key) {

        $iv = substr(hash('sha256', $key), 0, 16);

        return openssl_decrypt(
            $encryptedText,
            'AES-256-CBC',
            $key,
            0,
            $iv
        );
    }
}

?>