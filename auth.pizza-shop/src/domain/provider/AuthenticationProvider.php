<?php

namespace pizzashop\auth\api\domain\provider;

use Exception;
use mysqli;

class AuthenticationProvider
{
    private $db;

    public function __construct($host, $username, $password, $database)
    {
        $this->db = new mysqli($host, $username, $password, $database);

        if ($this->db->connect_error) {
            die("Erreur de connexion à la base de données: " . $this->db->connect_error);
        }
    }

    public function createTables(): void
    {
        $query = "Create table if not exists users (
            email varchar(255) primary key,
            password varchar(255) not null,
            active tinyint(4) not null default 0,
            activation_token varchar(64) default null,
            activation_token_expiration_date timestamp null default null,
            refresh_token varchar(255) default null,
            refresh_token_expiration_date timestamp null default null,
            reset_passwd_token varchar(64) default null,
            reset_passwd_token_expiration_date timestamp null default null, 
            username varchar(64) default null
        )";
        $this->db->query($query);
    }

    /**
     * @throws Exception
     */
    public function hashPassword($password): array
    {
        $salt = bin2hex(random_bytes(16));
        $passwordHash = hash("sha256", $password . $salt);
        return [$passwordHash, $salt];
    }

    /**
     * @throws Exception
     */
    public function createUser($username, $email, $password): void
    {
        list($passwordHash, $salt) = $this->hashPassword($password);
        $query = "INSERT INTO users (username, email, password, refresh_token) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $refreshToken = null;
        $stmt->bind_param("ssss", $username, $email, $passwordHash, $refreshToken);
        $stmt->execute();
    }

    public function authenticateWithCredentials($username, $password): bool
    {
        $query = "SELECT password, salt FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($storedPassword, $salt);
        $stmt->fetch();

        $inputPasswordHash = hash("sha256", $password . $salt);

        if ($inputPasswordHash === $storedPassword) {
            return true;
        }

        return false;
    }

    public function authenticateWithRefreshToken($refreshToken): ?array
    {
        $query = "SELECT username, email FROM users WHERE refresh_token = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $refreshToken);
        $stmt->execute();
        $stmt->bind_result($username, $email);
        $stmt->fetch();

        if ($username) {
            return [$username, $email];
        }

        return null;
    }

    public function getUserProfile($username): ?array
    {
        $query = "SELECT username, email, refresh_token FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($username, $email, $refreshToken);
        $stmt->fetch();

        if ($username) {
            return ['username' => $username, 'email' => $email, 'refresh_token' => $refreshToken];
        }

        return null;
    }

    public function close(): void
    {
        $this->db->close();
    }
}