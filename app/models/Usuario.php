<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Model.php';

class Usuario extends Model {

    public function login($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = ? AND estado = 1 LIMIT 1";
        $result = $this->query($sql, [$email], "s");
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Try hashed password first (security best practice)
            if (password_verify($password, $user['password'])) {
                return $user;
            }
            
            // FALLBACK: Plain text comparison (only for transitional purposes as requested by user)
            if ($password === $user['password']) {
                return $user;
            }
        }
        return false;
    }

    public function getById($id) {
        $sql = "SELECT id, nombre, email, role, created_at FROM usuarios WHERE id = ?";
        return $this->query($sql, [$id], "i")->fetch_assoc();
    }
}