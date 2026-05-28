<?php

class PasswordGenerator {

    private $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    private $numbers = '0123456789';
    private $special = '!@#$%^&*()_+=';

    public function generatePassword(
        $upperCount,
        $lowerCount,
        $numberCount,
        $specialCount
    ) {

        $password = '';

        for($i = 0; $i < $upperCount; $i++) {
            $password .= $this->uppercase[rand(0, strlen($this->uppercase)-1)];
        }

        for($i = 0; $i < $lowerCount; $i++) {
            $password .= $this->lowercase[rand(0, strlen($this->lowercase)-1)];
        }

        for($i = 0; $i < $numberCount; $i++) {
            $password .= $this->numbers[rand(0, strlen($this->numbers)-1)];
        }

        for($i = 0; $i < $specialCount; $i++) {
            $password .= $this->special[rand(0, strlen($this->special)-1)];
        }

        $password = str_shuffle($password);

        return $password;
    }
}

?>