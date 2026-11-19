CREATE DATABASE IF NOT EXISTS sisinventario;
USE sisinventario;

-- 1. Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'vendedor') DEFAULT 'admin',
    estado TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 5,
    estado ENUM('disponible', 'bajo_stock', 'agotado') AS (
        CASE 
            WHEN stock <= 0 THEN 'agotado'
            WHEN stock <= stock_minimo THEN 'bajo_stock'
            ELSE 'disponible'
        END
    ) STORED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Facturas (Cabecera)
CREATE TABLE facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nombre VARCHAR(150) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    id_usuario INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Detalle de Factura
CREATE TABLE detalle_factura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_factura) REFERENCES facturas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Historial de Transacciones
CREATE TABLE historial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    accion VARCHAR(50) NOT NULL, -- 'crear', 'editar', 'eliminar', 'venta'
    detalle TEXT,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserción de administrador por defecto (usuario: admin@ferrestock.com | password: admin123)
-- El hash corresponde a 'admin123' generado con password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO usuarios (nombre, email, password, role) VALUES 
('Administrador', 'admin@ferrestock.com', 'admin123', 'admin');

-- Algunos productos de ejemplo para ferretería
INSERT INTO productos (nombre, descripcion, precio, stock, stock_minimo) VALUES 
('Martillo de Acero 16oz', 'Herramienta manual para carpintería', 15.50, 20, 5),
('Taladro Inalámbrico 18V', 'Marca Industrial Pro con maletín', 85.00, 8, 3),
('Cinta Métrica 5m', 'Cinta métrica retráctil con freno', 4.20, 50, 10),
('Destornillador Phillips', 'Vástago de acero cromo vanadio', 3.50, 0, 5),
('Cerradura de Pomo', 'Llave/Mariposa acabado acero', 12.90, 4, 5);
