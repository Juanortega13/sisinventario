<?php

class Database {
    private $host = "localhost";
    private $db_name = "sisinventario";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
        } catch (Exception $e) {
            error_log($e->getMessage());
            die("Error de conexión a la base de datos. Verifique su configuración.");
        }

        return $this->conn;
    }
}