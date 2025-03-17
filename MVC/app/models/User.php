<?php
namespace App\Models;

use Core\Model;
use Core\Database;
use Core\JWT;
use PDO;
use PDOException;

class User extends Model {
    private $db;
    private $table = 'users';

    public function __construct() {
        $this->db = new Database();
    }

    public function register($data) {
        // Validate data
        if (!isset($data['email']) || !isset($data['password']) || !isset($data['name'])) {
            return ['status' => 'error', 'message' => 'Name, email and password are required'];
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Invalid email format'];
        }
        
        if (strlen($data['password']) < 6) {
            return ['status' => 'error', 'message' => 'Password must be at least 6 characters'];
        }
        
        try {
            $conn = $this->db->connect();
            
            // Check if user exists
            $stmt = $conn->prepare("SELECT id FROM {$this->table} WHERE email = :email");
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ['status' => 'error', 'message' => 'User already exists'];
            }
            
            // Hash password
            $password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
            
            // Insert user
            $query = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $conn->prepare($query);
            
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $password_hash);
            
            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'User registered successfully'];
            }
            
            return ['status' => 'error', 'message' => 'Failed to register user'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function login($data) {
        // Validate data
        if (!isset($data['email']) || !isset($data['password'])) {
            return ['status' => 'error', 'message' => 'Email and password are required'];
        }
        
        try {
            $conn = $this->db->connect();
            
            $stmt = $conn->prepare("SELECT id, name, email, password FROM {$this->table} WHERE email = :email");
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                return ['status' => 'error', 'message' => 'Invalid credentials'];
            }
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($data['password'], $user['password'])) {
                $jwt = new JWT();
                $token = $jwt->generateToken([
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name']
                ]);
                
                return [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email']
                    ]
                ];
            }
            
            return ['status' => 'error', 'message' => 'Invalid credentials'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    public function getUser($id) {
        try {
            $conn = $this->db->connect();
            
            $stmt = $conn->prepare("SELECT id, name, email FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function getAllUsers() {
        try {
            $conn = $this->db->connect();
            
            $stmt = $conn->query("SELECT id, name, email FROM {$this->table}");
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function updateUser($id, $data) {
        try {
            $conn = $this->db->connect();
            
            $query = "UPDATE {$this->table} SET ";
            $params = [];
            
            if (isset($data['name'])) {
                $query .= "name = :name, ";
                $params[':name'] = $data['name'];
            }
            
            if (isset($data['email'])) {
                $query .= "email = :email, ";
                $params[':email'] = $data['email'];
            }
            
            if (isset($data['password'])) {
                $query .= "password = :password, ";
                $params[':password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }
            
            $query = rtrim($query, ', ') . " WHERE id = :id";
            $params[':id'] = $id;
            
            $stmt = $conn->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function deleteUser($id) {
        try {
            $conn = $this->db->connect();
            
            $stmt = $conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
