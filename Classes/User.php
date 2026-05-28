<?php

require_once '../config/Database.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($username, $password) {

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $generatedKey = openssl_random_pseudo_bytes(32);

        $encryptedKey = openssl_encrypt(
            base64_encode($generatedKey),
            'AES-256-CBC',
            $password,
            0,
            substr($generatedKey, 0, 16)
        );

        $sql = "INSERT INTO users(username, password_hash, encryption_key)
                VALUES(:username, :password_hash, :encryption_key)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':password_hash' => $passwordHash,
            ':encryption_key' => $encryptedKey
        ]);
    }

    public function login($username, $password) {

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }
}

?>