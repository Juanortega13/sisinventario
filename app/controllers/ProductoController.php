<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Producto.php';

class ProductoController extends Controller {

    public function index() {
        $this->checkAuth();
        $model = new Producto();
        $productos = $model->getAll();
        
        $this->renderView('inventory/list', [
            'productos' => $productos,
            'title' => 'Inventario — FerroStock'
        ]);
    }

    public function create() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Producto();
            $success = $model->crear(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['stock'],
                $_POST['stock_minimo']
            );

            if ($success) {
                $this->logActivity($_SESSION['user']['id'], 'crear', 'Producto creado: ' . $_POST['nombre']);
                header("Location: index.php?route=inventory");
                exit;
            }
        }
        $this->renderView('inventory/form', ['title' => 'Nuevo Producto — FerroStock']);
    }

    public function edit() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) header("Location: index.php?route=inventory");

        $model = new Producto();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $model->actualizar(
                $id,
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precio'],
                $_POST['stock'],
                $_POST['stock_minimo']
            );

            if ($success) {
                $this->logActivity($_SESSION['user']['id'], 'editar', 'Producto editado: ID ' . $id);
                header("Location: index.php?route=inventory");
                exit;
            }
        }

        $producto = $model->getById($id);
        $this->renderView('inventory/form', [
            'producto' => $producto,
            'title' => 'Editar Producto — FerroStock'
        ]);
    }

    public function delete() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $model = new Producto();
            $model->eliminar($id);
            $this->logActivity($_SESSION['user']['id'], 'eliminar', 'Producto eliminado: ID ' . $id);
        }
        header("Location: index.php?route=inventory");
    }
}
