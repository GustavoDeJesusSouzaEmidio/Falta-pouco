<?php

require_once __DIR__ . '/../models/venda.php';

class VendaController
{
    private Venda $venda;

    public function __construct()
    {
        $this->venda = new Venda();
    }

    public function index(): void
    {
        $this->check();

        $vendas = $this->venda->listar();

        require_once __DIR__ . '/../views/vendas.php';
    }

    public function nova(): void
    {
        $this->check();

        $clientes = $this->venda->listarClientes();

        $variacoes = $this->venda->listarVariacoes();

        $vendas = $this->venda->listar();

        require_once __DIR__ . '/../views/vendas.php';
    }

    public function show(int $id): ?array
    {
        $this->check();

        return $this->venda->buscarPorId($id);
    }

    public function itens(int $vendaId): array
    {
        $this->check();

        return $this->venda->listarItens($vendaId);
    }

    public function store(): void
    {
        $this->check();

        $usuarioId = (int)($_SESSION['usuario_id'] ?? 0);

        $clienteId = (int)($_POST['cliente_id'] ?? 0);

        $data = date('Y-m-d');

        $itens = $_POST['itens'] ?? [];

        if ($usuarioId <= 0) {
            die("Usuário inválido.");
        }

        if ($clienteId <= 0) {
            die("Cliente é obrigatório.");
        }

        if (empty($itens)) {
            die("É necessário adicionar pelo menos um item.");
        }

        $valorTotal = 0;

        // Primeiro verifica todos os itens
        foreach ($itens as $item) {

            $variacaoId = (int)($item['variacao_id'] ?? 0);
            $quantidade = (int)($item['quantidade'] ?? 0);
            $precoUnitario = (float)($item['preco_unitario'] ?? 0);

            if ($variacaoId <= 0) {
                die("Variação inválida.");
            }

            if ($quantidade <= 0) {
                die("A quantidade deve ser maior que zero.");
            }

            if ($precoUnitario < 0) {
                die("O preço unitário não pode ser negativo.");
            }

            $estoqueAtual = $this->venda->consultarEstoque(
                $variacaoId
            );

            if ($quantidade > $estoqueAtual) {
                die(
                    "Estoque insuficiente para a variação "
                    . $variacaoId
                    . ". Disponível: "
                    . $estoqueAtual
                    . "."
                );
            }

            $valorTotal += $quantidade * $precoUnitario;
        }

        // Cria a venda
        $vendaId = $this->venda->inserir(
            $usuarioId,
            $clienteId,
            $data,
            $valorTotal
        );

        // Registra os itens e baixa o estoque
        foreach ($itens as $item) {

            $variacaoId = (int)$item['variacao_id'];
            $quantidade = (int)$item['quantidade'];
            $precoUnitario = (float)$item['preco_unitario'];

            $atualizou = $this->venda->atualizarEstoque(
                $variacaoId,
                $quantidade
            );

            if (!$atualizou) {
                die("Não foi possível atualizar o estoque.");
            }

            $this->venda->inserirItem(
                $vendaId,
                $variacaoId,
                $quantidade,
                $precoUnitario
            );

            $this->venda->registrarMovimento(
                $variacaoId,
                'saida',
                $quantidade,
                'venda',
                $vendaId,
                $data
            );
        }

        header("Location: index.php?controller=venda&action=nova");
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