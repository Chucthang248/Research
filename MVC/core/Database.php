<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    private $options;

    public function __construct() {
        $config = require_once '../config/config.php';
        $db_config = $config['database'];
        
        $this->host = $db_config['host'];
        $this->db_name = $db_config['name'];
        $this->username = $db_config['user'];
        $this->password = $db_config['password'];
        $this->options = $db_config['options'];
    }

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password,
                $this->options
            );
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
