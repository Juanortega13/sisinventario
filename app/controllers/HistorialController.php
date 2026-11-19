<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Historial.php';

class HistorialController extends Controller {

    public function index() {
        $this->checkAuth();
        $model = new Historial();
        $logs = $model->getAll();
        
        $this->renderView('history/index', [
            'logs' => $logs,
            'title' => 'Historial de Transacciones — FerroStock'
        ]);
    }
}
