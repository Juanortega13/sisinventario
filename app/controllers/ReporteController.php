<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Producto.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Factura.php';

class ReporteController extends Controller {

    public function index() {
        $this->checkAuth();
        
        $productoModel = new Producto();
        $facturaModel = new Factura();

        $stats = $productoModel->getEstadisticas();
        $productosBajoStock = $productoModel->getLowStock();
        $productosAgotados = $productoModel->getOutOfStock();
        $todasVentas = $facturaModel->getAll();
        $totalVentasValor = $facturaModel->getTotalVentas();

        $this->renderView('reports/index', [
            'stats' => $stats,
            'bajoStock' => $productosBajoStock,
            'agotados' => $productosAgotados,
            'ventas' => $todasVentas,
            'totalVentas' => $totalVentasValor,
            'title' => 'Reportes — FerroStock'
        ]);
    }
}
