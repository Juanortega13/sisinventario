<?php

class Controller {
    
    protected function renderView($view, $data = [], $layout = 'main') {
        // Extract data to make it available in the view
        extract($data);
        
        $viewPath = APP_PATH . "views" . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $view) . ".php";
        
        if (!file_exists($viewPath)) {
            die("Error crítico: Vista [$view] no encontrada en: $viewPath");
        }

        // Buffer the view content
        ob_start();
        require_once $viewPath;
        $content = ob_get_clean();

        // Check if layout is requested
        if ($layout) {
            $layoutPath = APP_PATH . "views" . DIRECTORY_SEPARATOR . "layouts" . DIRECTORY_SEPARATOR . $layout . ".php";
            if (file_exists($layoutPath)) {
                require_once $layoutPath;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }

    protected function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "index.php?route=login");
            exit;
        }
    }

    protected function logActivity($id_usuario, $accion, $detalle) {
        require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Historial.php';
        $historial = new Historial();
        $historial->registrar($id_usuario, $accion, $detalle);
    }

    protected function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
