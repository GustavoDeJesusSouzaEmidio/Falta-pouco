
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/config/db.php';
Database::getConnection();

// Página inicial padrão
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Carregar controller
switch ($controller) {
    case 'home':
        require_once __DIR__ . '/controllers/HomeController.php';
        $c = new HomeController();
        break;

    case 'dashboard':
        require_once __DIR__ . '/controllers/DashboardController.php';
        $c = new DashboardController();
        break;

    case 'auth':
        require_once __DIR__ . '/controllers/AuthController.php';
        $c = new AuthController();
        break;

    case 'produto':
        require_once __DIR__ . '/controllers/ProdutoController.php';
        $c = new ProdutoController();
        break;

    case 'entrada':
        require_once __DIR__ . '/controllers/EntradaController.php';
        $c = new EntradaController();
        break;

    case 'venda':
        require_once __DIR__ . '/controllers/VendaController.php';
        $c = new VendaController();
        break;

    case 'relatorio':
        require_once __DIR__ . '/controllers/RelatorioController.php';
        $c = new RelatorioController();
        break;

    case 'usuario':
        require_once __DIR__ . '/controllers/UsuarioController.php';
        $c = new UsuarioController();
        break;

    case 'fornecedor':
        require_once __DIR__ . '/controllers/FornecedorController.php';
        $c = new FornecedorController();
        break;

    case 'categoria':
        require_once __DIR__ . '/controllers/CategoriaController.php';
        $c = new CategoriaController();
        break;

    case 'sobre':
        require_once __DIR__ . '/controllers/SobreController.php';
        $c = new SobreController();
        break;

    case 'livros':
        require_once __DIR__ . '/controllers/LivrosController.php';
        $c = new LivrosController();
        break;

    case 'cep':
        require_once __DIR__ . '/controllers/CepController.php';
        $c = new CepController();
        break;

    case 'genero':
        require_once __DIR__ . '/controllers/GeneroController.php';
        $c = new GeneroController();
        break;

    case 'loja':
        require_once __DIR__ . '/controllers/LojaController.php';
        $c = new LojaController();
        break;

    default:
        http_response_code(404);
        die('Página não encontrada.');
}

// Executar ação
if (!method_exists($c, $action)) {
    http_response_code(404);
    die('Página não encontrada.');
}

$c->$action();