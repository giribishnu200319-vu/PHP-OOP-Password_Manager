<?php
require_once '../config/Database.php';
require_once 'Encryption.php';

class PasswordEntry {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function savePassword($userId, $website, $password, $key) {

        $encryptedPassword = Encryption::encrypt($password, $key);

        $sql = "INSERT INTO passwords(user_id, website_name, encrypted_password)
                VALUES(:user_id, :website_name, :encrypted_password)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':website_name' => $website,
            ':encrypted_password' => $encryptedPassword
        ]);
    }

    public function getPasswords($userId) {

        $sql = "SELECT * FROM passwords WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>