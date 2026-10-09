<?php

require_once __DIR__ . '/../models/Fornecedor.php';

class FornecedorController
{
    public function index(): void
    {
        $this->check();

        $fornecedorModel = new Fornecedor();
        $fornecedores = $fornecedorModel->listar();

        $editar = null;

        if (isset($_GET['id'])) {
            $editar = $fornecedorModel->buscarPorId((int)$_GET['id']);
        }

        require_once __DIR__ . '/../views/fornecedores.php';
    }

    public function salvar(): void
    {
        $this->check();
        $this->onlyAdmin();

        $id = (int)($_POST['id'] ?? 0);

        $nome = trim($_POST['nome'] ?? '');
        $cnpj = trim($_POST['cnpj'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $cep = trim($_POST['cep'] ?? '');
        $endereco = trim($_POST['endereco'] ?? '');

        $telefone = $telefone === '' ? null : $telefone;
        $email = $email === '' ? null : $email;
        $cep = $cep === '' ? null : $cep;
        $endereco = $endereco === '' ? null : $endereco;

        if ($nome === '') {
            die("Nome do fornecedor é obrigatório.");
        }

        if ($id > 0) {

            $fornecedorModel = new Fornecedor();

            $fornecedorModel->atualizar(
                $id,
                $nome,
                $cnpj,
                $telefone,
                $email,
                $cep,
                $endereco
            );

        } else {

            $fornecedorModel = new Fornecedor();

            $fornecedorModel->inserir(
                $nome,
                $cnpj,
                $telefone,
                $email,
                $cep,
                $endereco
            );
        }

        header("Location: index.php?controller=fornecedor&action=index");
        exit;
    }


    public function deletar(): void
    {
        $this->check();
        $this->onlyAdmin();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            die("ID inválido.");
        }

        $fornecedorModel = new Fornecedor();

        $fornecedorModel->deletar($id);

        header("Location: index.php?controller=fornecedor&action=index");
        exit;
    }


    public function toggle(): void
    {
        $this->check();
        $this->onlyAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $ativo = (int)($_GET['ativo'] ?? 0);

        if ($id <= 0) {
            die("ID inválido.");
        }

        if ($ativo !== 0 && $ativo !== 1) {
            die("Status inválido.");
        }

        $fornecedorModel = new Fornecedor();

        $fornecedorModel->alterarStatus($id, $ativo);

        header("Location: index.php?controller=fornecedor&action=index");
        exit;
    }


    private function check(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=auth&action=form");
            exit;
        }
    }


    private function onlyAdmin(): void
    {
        if (($_SESSION['perfil'] ?? '') !== 'admin') {
            die("Acesso negado.");
        }
    }
}