<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Model.php';

class Historial extends Model {

    public function registrar($id_usuario, $accion, $detalle) {
        $sql = "INSERT INTO historial (id_usuario, accion, detalle) VALUES (?, ?, ?)";
        return $this->execute($sql, [$id_usuario, $accion, $detalle], "iss");
    }

    public function getAll() {
        $sql = "SELECT h.*, u.nombre as usuario_nombre 
                FROM historial h 
                LEFT JOIN usuarios u ON h.id_usuario = u.id 
                ORDER BY h.fecha_hora DESC";
        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
