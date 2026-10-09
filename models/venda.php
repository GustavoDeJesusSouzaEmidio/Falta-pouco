<?php

require_once __DIR__ . '/../config/db.php';

class Venda
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // Lista todas as vendas
    public function listar(): array
    {
        $sql = "
            SELECT
                v.id_venda,
                v.data,
                v.valor_total,
                c.nome AS cliente_nome,
                u.nome AS vendedor_nome
            FROM venda v
            INNER JOIN cliente c
                ON c.id = v.cliente_id
            INNER JOIN usuario u
                ON u.id = v.usuario_id
            ORDER BY v.id_venda DESC
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Busca uma venda pelo ID
    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT
                v.id_venda,
                v.data,
                v.valor_total,
                v.usuario_id,
                v.cliente_id,
                c.nome AS cliente_nome,
                u.nome AS vendedor_nome
            FROM venda v
            INNER JOIN cliente c
                ON c.id = v.cliente_id
            INNER JOIN usuario u
                ON u.id = v.usuario_id
            WHERE v.id_venda = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        $venda = $stmt->fetch();

        return $venda ?: null;
    }

    // Lista os itens de uma venda
    public function listarItens(int $vendaId): array
    {
        $stmt = $this->conn->prepare("
            SELECT
                iv.id_item_venda,
                iv.venda_id,
                iv.variacao_id,
                iv.quantidade,
                iv.preco_unitario,
                p.nome AS produto_nome,
                va.isbn,
                va.formato,
                va.edicao
            FROM item_venda iv
            INNER JOIN variacao va
                ON va.id_variacao = iv.variacao_id
            INNER JOIN produto p
                ON p.id = va.produto_id
            WHERE iv.venda_id = :venda_id
            ORDER BY iv.id_item_venda
        ");

        $stmt->execute([
            ':venda_id' => $vendaId
        ]);

        return $stmt->fetchAll();
    }

    // Lista os clientes
    public function listarClientes(): array
    {
        $sql = "
            SELECT
                id,
                nome
            FROM cliente
            ORDER BY nome
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Lista as variações/SKUs disponíveis
    public function listarVariacoes(): array
    {
        $sql = "
            SELECT
                va.id_variacao,
                va.isbn,
                va.formato,
                va.edicao,
                l.preco AS preco_venda,
                p.nome AS produto_nome
            FROM variacao va
            INNER JOIN produto p
                ON p.id = va.produto_id
            LEFT JOIN livro l
                ON l.id_livro = p.id
            ORDER BY p.nome, va.id_variacao
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Cria uma nova venda
    public function inserir(
        int $usuarioId,
        int $clienteId,
        string $data,
        float $valorTotal
    ): int {
        $stmt = $this->conn->prepare("
            INSERT INTO venda
                (data, valor_total, usuario_id, cliente_id)
            VALUES
                (:data, :valor_total, :usuario_id, :cliente_id)
        ");

        $stmt->execute([
            ':data' => $data,
            ':valor_total' => $valorTotal,
            ':usuario_id' => $usuarioId,
            ':cliente_id' => $clienteId
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Adiciona um item à venda
    public function inserirItem(
        int $vendaId,
        int $variacaoId,
        int $quantidade,
        float $precoUnitario
    ): int {
        $stmt = $this->conn->prepare("
            INSERT INTO item_venda
                (venda_id, variacao_id, quantidade, preco_unitario)
            VALUES
                (:venda_id, :variacao_id, :quantidade, :preco_unitario)
        ");

        $stmt->execute([
            ':venda_id' => $vendaId,
            ':variacao_id' => $variacaoId,
            ':quantidade' => $quantidade,
            ':preco_unitario' => $precoUnitario
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Verifica quanto existe no estoque
    public function consultarEstoque(int $variacaoId): int
    {
        $stmt = $this->conn->prepare("
            SELECT quantidade
            FROM estoque
            WHERE variacao_id = :variacao_id
        ");

        $stmt->execute([
            ':variacao_id' => $variacaoId
        ]);

        $estoque = $stmt->fetch();

        return $estoque ? (int) $estoque['quantidade'] : 0;
    }

    // Diminui o estoque sem permitir estoque negativo
    public function atualizarEstoque(
        int $variacaoId,
        int $quantidade
    ): bool {
        $stmt = $this->conn->prepare("
            UPDATE estoque
            SET quantidade = quantidade - :quantidade
            WHERE variacao_id = :variacao_id
              AND quantidade >= :quantidade
        ");

        $stmt->execute([
            ':quantidade' => $quantidade,
            ':variacao_id' => $variacaoId
        ]);

        return $stmt->rowCount() > 0;
    }

    // Registra a saída no histórico de estoque
    public function registrarMovimento(
        int $variacaoId,
        string $tipo,
        int $quantidade,
        string $origem,
        int $origemId,
        string $data
    ): void {
        $stmt = $this->conn->prepare("
            INSERT INTO movimento_estoque
                (variacao_id, tipo, quantidade, origem, origem_id, data)
            VALUES
                (:variacao_id, :tipo, :quantidade, :origem, :origem_id, :data)
        ");

        $stmt->execute([
            ':variacao_id' => $variacaoId,
            ':tipo' => $tipo,
            ':quantidade' => $quantidade,
            ':origem' => $origem,
            ':origem_id' => $origemId,
            ':data' => $data
        ]);
    }
}