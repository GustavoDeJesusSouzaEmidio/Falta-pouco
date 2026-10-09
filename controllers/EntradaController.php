<?php

require_once __DIR__ . '/../models/entrada.php';
require_once __DIR__ . '/../models/Fornecedor.php';

class EntradaController
{
    private Entrada $entrada;

    public function __construct()
    {
        $this->entrada = new Entrada();
    }

    public function index(): void
    {
        $this->check();

        $fornecedorModel = new Fornecedor();

        $fornecedores = $fornecedorModel->listar();
        $variacoes = $this->entrada->listarVariacoes();
        $entradas = $this->entrada->listar();

        require_once __DIR__ . '/../views/entradas.php';
    }

    public function nova(): void
    {
        $this->check();

        $fornecedorModel = new Fornecedor();

        $fornecedores = $fornecedorModel->listar();
        $variacoes = $this->entrada->listarVariacoes();
        $entradas = $this->entrada->listar();

        require_once __DIR__ . '/../views/entradas.php';
    }

    public function show(int $id): ?array
    {
        $this->check();

        return $this->entrada->buscarPorId($id);
    }

    public function itens(int $entradaId): array
    {
        $this->check();

        return $this->entrada->listarItens($entradaId);
    }

    public function store(): void
    {
        $this->check();

        $fornecedorId = (int)($_POST['fornecedor_id'] ?? 0);

        $data = date('Y-m-d');

        $itens = $_POST['itens'] ?? [];

        if ($fornecedorId <= 0) {
            die("Fornecedor é obrigatório.");
        }

        if (empty($itens)) {
            die("É necessário adicionar pelo menos um item.");
        }

        $entradaId = $this->entrada->inserir(
            $fornecedorId,
            $data
        );

        foreach ($itens as $item) {

            $variacaoId = (int)($item['variacao_id'] ?? 0);
            $quantidade = (int)($item['quantidade'] ?? 0);
            $custoUnitario = (float)($item['custo_unitario'] ?? 0);

            if ($variacaoId <= 0) {
                die("Variação inválida.");
            }

            if ($quantidade <= 0) {
                die("A quantidade deve ser maior que zero.");
            }

            if ($custoUnitario < 0) {
                die("O custo unitário não pode ser negativo.");
            }

            $this->entrada->inserirItem(
                $entradaId,
                $variacaoId,
                $quantidade,
                $custoUnitario
            );

            $this->entrada->atualizarEstoque(
                $variacaoId,
                $quantidade
            );

            $this->entrada->registrarMovimento(
                $variacaoId,
                'entrada',
                $quantidade,
                'entrada',
                $entradaId,
                $data
            );
        }

        header("Location: index.php?controller=entrada&action=index");
        exit;
    }

    private function check(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=auth&action=form");
            exit;
        }
    }
}