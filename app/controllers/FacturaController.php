<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Factura.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Producto.php';

class FacturaController extends Controller {

    public function index() {
        $this->checkAuth();
        $model = new Factura();
        $facturas = $model->getAll();
        
        $this->renderView('billing/list', [
            'facturas' => $facturas,
            'title' => 'Facturación — FerroStock'
        ]);
    }

    public function create() {
        $this->checkAuth();
        $productoModel = new Producto();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = $_POST['cliente_nombre'];
            $total = $_POST['total'];
            $items = json_decode($_POST['items'], true); // Los items vendrán como JSON desde el front

            $model = new Factura();
            $id_factura = $model->crear($cliente, $total, $_SESSION['user']['id'], $items);

            if ($id_factura) {
                $this->logActivity($_SESSION['user']['id'], 'venta', 'Factura creada: #' . $id_factura . ' para ' . $cliente);
                $this->jsonResponse(['success' => true, 'redirect' => 'index.php?route=billing']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Error al crear la factura']);
            }
        }

        $productos = $productoModel->getAll();
        $this->renderView('billing/form', [
            'productos' => $productos,
            'title' => 'Nueva Factura — FerroStock'
        ]);
    }

    public function detail() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) header("Location: index.php?route=billing");

        $model = new Factura();
        $factura = $model->getById($id);
        
        $this->renderView('billing/detail', [
            'factura' => $factura,
            'title' => 'Detalle de Factura — FerroStock'
        ], null); // No layout for printable version? Or specific layout? Let's use main for now.
    }
}
