<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Producto.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Factura.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Historial.php';

class DashboardController extends Controller {

    public function index() {
        $this->checkAuth();

        $productoModel = new Producto();
        $facturaModel = new Factura();
        $historialModel = new Historial();

        $estadisticas = $productoModel->getEstadisticas();
        $ventasRecientes = $facturaModel->getUltimasVentas(5);
        $actividadReciente = $historialModel->getAll();
        
        // Limit activity to 5 for dashboard
        $actividadReciente = array_slice($actividadReciente, 0, 5);

        $this->renderView('dashboard', [
            'stats' => $estadisticas,
            'ventas' => $ventasRecientes,
            'actividad' => $actividadReciente,
            'title' => 'Dashboard — FerroStock'
        ]);
    }
}
