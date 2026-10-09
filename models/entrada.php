<?php

require_once __DIR__ . '/../config/db.php';

class Entrada
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // Lista todas as entradas
    public function listar(): array
    {
        $sql = "
            SELECT
                e.id_entrada,
                e.data,
                f.nome AS fornecedor_nome,
                COALESCE(
                    SUM(ie.quantidade * ie.custo_unitario),
                    0
                ) AS valor_total
            FROM entrada e

            INNER JOIN fornecedor f
                ON f.id = e.fornecedor_id

            LEFT JOIN item_entrada ie
                ON ie.entrada_id = e.id_entrada

            GROUP BY
                e.id_entrada,
                e.data,
                f.nome

            ORDER BY e.id_entrada DESC
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Busca uma entrada pelo ID
    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT
                e.id_entrada,
                e.fornecedor_id,
                e.data,
                f.nome AS fornecedor_nome
            FROM entrada e
            INNER JOIN fornecedor f
                ON f.id = e.fornecedor_id
            WHERE e.id_entrada = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        $entrada = $stmt->fetch();

        return $entrada ?: null;
    }

    // Lista os itens de uma entrada
    public function listarItens(int $entradaId): array
    {
        $stmt = $this->conn->prepare("
            SELECT
                ie.id_item_entrada,
                ie.entrada_id,
                ie.variacao_id,
                ie.quantidade,
                ie.custo_unitario,
                p.nome AS produto_nome,
                v.isbn,
                v.formato,
                v.edicao
            FROM item_entrada ie
            INNER JOIN variacao v
                ON v.id_variacao = ie.variacao_id
            INNER JOIN produto p
                ON p.id = v.produto_id
            WHERE ie.entrada_id = :entrada_id
            ORDER BY ie.id_item_entrada
        ");

        $stmt->execute([
            ':entrada_id' => $entradaId
        ]);

        return $stmt->fetchAll();
    }

    // Lista as variações disponíveis
    public function listarVariacoes(): array
    {
        $sql = "
            SELECT
                v.id_variacao,
                v.isbn,
                v.formato,
                v.edicao,
                l.preco AS preco_custo,
                p.nome AS produto_nome
            FROM variacao v
            INNER JOIN produto p
                ON p.id = v.produto_id
            LEFT JOIN livro l
                ON l.id_livro = p.id
            ORDER BY p.nome, v.id_variacao
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Cria uma nova entrada
    public function inserir(int $fornecedorId, string $data): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO entrada
                (fornecedor_id, data)
            VALUES
                (:fornecedor_id, :data)
        ");

        $stmt->execute([
            ':fornecedor_id' => $fornecedorId,
            ':data' => $data
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Adiciona um item à entrada
    public function inserirItem(
        int $entradaId,
        int $variacaoId,
        int $quantidade,
        float $custoUnitario
    ): int {
        $stmt = $this->conn->prepare("
            INSERT INTO item_entrada
                (entrada_id, variacao_id, quantidade, custo_unitario)
            VALUES
                (:entrada_id, :variacao_id, :quantidade, :custo_unitario)
        ");

        $stmt->execute([
            ':entrada_id' => $entradaId,
            ':variacao_id' => $variacaoId,
            ':quantidade' => $quantidade,
            ':custo_unitario' => $custoUnitario
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Registra a movimentação de estoque
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

    // Atualiza o estoque
    public function atualizarEstoque(
        int $variacaoId,
        int $quantidade
    ): void {
        $stmt = $this->conn->prepare("
            UPDATE estoque
            SET quantidade = quantidade + :quantidade
            WHERE variacao_id = :variacao_id
        ");

        $stmt->execute([
            ':quantidade' => $quantidade,
            ':variacao_id' => $variacaoId
        ]);
    }
}