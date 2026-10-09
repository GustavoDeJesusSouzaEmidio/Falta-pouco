
<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    public function form(): void
    {
        $tipo = $_GET['tipo'] ?? '';

        if (!in_array($tipo, ['cliente', 'admin'], true)) {
            $tipo = '';
        }

        require __DIR__ . '/../views/login.php';
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $tipo = $_POST['tipo'] ?? '';

        if (!in_array($tipo, ['cliente', 'admin'], true)) {
            header('Location: index.php');
            exit;
        }

        if ($email === '' || $senha === '') {
            die('Preencha o e-mail e a senha.');
        }

        $usuarioModel = new Usuario();
        $user = $usuarioModel->buscarPorEmail($email);

        if (
            !$user ||
            (int) $user['ativo'] !== 1 ||
            !password_verify($senha, $user['senha'])
        ) {
            die('E-mail ou senha incorretos.');
        }

        $perfil = $user['perfil'];

        // Impede que o tipo de conta escolhido seja ignorado.
        if ($perfil !== $tipo) {
            die(
                $tipo === 'admin'
                    ? 'Esta conta não tem acesso de administrador.'
                    : 'Esta conta não está cadastrada como cliente.'
            );
        }

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = (int) $user['id'];
        $_SESSION['perfil'] = $perfil;
        $_SESSION['nome'] = $user['nome'];

        if ($perfil === 'admin') {
            header('Location: index.php?controller=dashboard&action=index');
            exit;
        }

        header('Location: index.php?controller=loja&action=index');
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: index.php');
        exit;
    }

    public function check(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    public function onlyAdmin(): void
    {
        $this->check();

        if (($_SESSION['perfil'] ?? '') !== 'admin') {
            http_response_code(403);
            die('Você não tem permissão para acessar esta página.');
        }
    }
}