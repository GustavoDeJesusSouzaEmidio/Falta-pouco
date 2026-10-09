
<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    public function create(): void
    {
        require_once __DIR__ . '/../views/cadastro.php';
    }

    public function store(): void
    {
        $nome = trim($_POST['nome'] ?? '');
        $cpfCnpj = trim($_POST['cpf_cnpj'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (
            $nome === '' ||
            $cpfCnpj === '' ||
            $email === '' ||
            $senha === ''
        ) {
            die('Por favor, preencha todos os campos.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Digite um e-mail válido.');
        }

        if (strlen($senha) < 6) {
            die('A senha deve ter pelo menos 6 caracteres.');
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $usuarioModel = new Usuario();

            $sucesso = $usuarioModel->cadastrarCliente(
                $nome,
                $cpfCnpj,
                $email,
                $senhaHash
            );

            if ($sucesso) {
                header('Location: index.php?controller=auth&action=form');
                exit;
            }

            die('Não foi possível criar a conta.');
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                die('Este e-mail ou CPF/CNPJ já pode estar cadastrado.');
            }

            error_log($e->getMessage());
            die('Ocorreu um erro ao cadastrar. Tente novamente.');
        }
    }
}