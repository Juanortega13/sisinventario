<?php
// routes/web.php

// Ensure controllers are loaded with robust absolute paths
require_once APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
require_once APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'DashboardController.php';
require_once APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'ProductoController.php';
require_once APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'FacturaController.php';
require_once APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'HistorialController.php';
require_once APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'ReporteController.php';

$route = $_GET['route'] ?? 'login';

$auth = new AuthController();
$dashboard = new DashboardController();
$productos = new ProductoController();
$facturas = new FacturaController();
$historial = new HistorialController();
$reportes = new ReporteController();

switch ($route) {
    // Auth
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->login();
        } else {
            $auth->showLogin();
        }
        break;
    case 'logout':
        $auth->logout();
        break;

    // Dashboard
    case 'dashboard':
        $dashboard->index();
        break;

    // Inventario
    case 'inventory':
        $productos->index();
        break;
    case 'inventory/create':
        $productos->create();
        break;
    case 'inventory/edit':
        $productos->edit();
        break;
    case 'inventory/delete':
        $productos->delete();
        break;

    // Facturación
    case 'billing':
        $facturas->index();
        break;
    case 'billing/create':
        $facturas->create();
        break;
    case 'billing/detail':
        $facturas->detail();
        break;

    // Historial
    case 'history':
        $historial->index();
        break;

    // Reportes
    case 'reports':
        $reportes->index();
        break;

    default:
        $auth->showLogin();
        break;
}