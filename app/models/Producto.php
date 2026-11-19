<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Model.php';

class Producto extends Model {

    public function getAll() {
        $sql = "SELECT * FROM productos ORDER BY nombre ASC";
        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getLowStock() {
        $sql = "SELECT * FROM productos WHERE stock <= stock_minimo AND stock > 0 ORDER BY stock ASC";
        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getOutOfStock() {
        $sql = "SELECT * FROM productos WHERE stock <= 0 ORDER BY nombre ASC";
        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        return $this->query($sql, [$id], "i")->fetch_assoc();
    }

    public function crear($nombre, $descripcion, $precio, $stock, $stock_minimo) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, stock_minimo) VALUES (?, ?, ?, ?, ?)";
        return $this->execute($sql, [$nombre, $descripcion, $precio, $stock, $stock_minimo], "ssdii");
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock, $stock_minimo) {
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, stock_minimo = ? WHERE id = ?";
        return $this->execute($sql, [$nombre, $descripcion, $precio, $stock, $stock_minimo, $id], "ssdiii");
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        return $this->execute($sql, [$id], "i");
    }

    public function actualizarStock($id, $cantidad) {
        $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        return $this->execute($sql, [$cantidad, $id], "ii");
    }

    public function getEstadisticas() {
        $sql = "SELECT 
                    COUNT(*) as total_productos,
                    SUM(CASE WHEN stock <= 0 THEN 1 ELSE 0 END) as agotados,
                    SUM(CASE WHEN stock <= stock_minimo AND stock > 0 THEN 1 ELSE 0 END) as bajo_stock,
                    SUM(precio * stock) as valor_total_inventario
                FROM productos";
        return $this->query($sql)->fetch_assoc();
    }
}
