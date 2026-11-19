<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Model.php';

class Factura extends Model {

    public function crear($cliente_nombre, $total, $id_usuario, $detalles) {
        $this->conn->begin_transaction();

        try {
            // 1. Insertar Factura
            $sql = "INSERT INTO facturas (cliente_nombre, total, id_usuario) VALUES (?, ?, ?)";
            $this->execute($sql, [$cliente_nombre, $total, $id_usuario], "sdi");
            $id_factura = $this->lastInsertId();

            // 2. Insertar Detalles y Actualizar Stock
            $sql_detalle = "INSERT INTO detalle_factura (id_factura, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
            $sql_stock = "UPDATE productos SET stock = stock - ? WHERE id = ?";

            foreach ($detalles as $item) {
                $this->execute($sql_detalle, [
                    $id_factura, 
                    $item['id_producto'], 
                    $item['cantidad'], 
                    $item['precio_unitario'], 
                    $item['subtotal']
                ], "iiidd");

                $this->execute($sql_stock, [$item['cantidad'], $item['id_producto']], "ii");
            }

            $this->conn->commit();
            return $id_factura;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT f.*, u.nombre as usuario_nombre 
                FROM facturas f 
                LEFT JOIN usuarios u ON f.id_usuario = u.id 
                ORDER BY f.created_at DESC";
        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT f.*, u.nombre as usuario_nombre 
                FROM facturas f 
                LEFT JOIN usuarios u ON f.id_usuario = u.id 
                WHERE f.id = ?";
        $factura = $this->query($sql, [$id], "i")->fetch_assoc();

        if ($factura) {
            $sql_detalles = "SELECT df.*, p.nombre as producto_nombre 
                             FROM detalle_factura df 
                             JOIN productos p ON df.id_producto = p.id 
                             WHERE df.id_factura = ?";
            $factura['detalles'] = $this->query($sql_detalles, [$id], "i")->fetch_all(MYSQLI_ASSOC);
        }

        return $factura;
    }

    public function getUltimasVentas($limit = 5) {
        $sql = "SELECT f.* FROM facturas f ORDER BY f.created_at DESC LIMIT ?";
        return $this->query($sql, [$limit], "i")->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalVentas() {
        $sql = "SELECT SUM(total) as gran_total FROM facturas";
        $row = $this->query($sql)->fetch_assoc();
        return $row['gran_total'] ?? 0;
    }
}
