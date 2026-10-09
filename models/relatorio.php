<?php

require_once __DIR__ . '/../config/db.php';

class Relatorio
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // Produtos mais vendidos
    public function produtosMaisVendidos(): array
    {
        $sql = "
            SELECT
                p.nome AS produto_nome,
                COALESCE(SUM(iv.quantidade), 0) AS quantidade_vendida
            FROM item_venda iv
            INNER JOIN variacao v
                ON v.id_variacao = iv.variacao_id
            INNER JOIN produto p
                ON p.id = v.produto_id
            GROUP BY
                p.id,
                p.nome
            ORDER BY
                quantidade_vendida DESC,
                p.nome ASC
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Fornecedores
    public function fornecedores(): array
    {
        $sql = "
            SELECT
                f.id,
                f.nome,
                COUNT(DISTINCT e.id_entrada) AS entradas,
                COALESCE(
                    SUM(ie.quantidade * ie.custo_unitario),
                    0
                ) AS valor_total
            FROM fornecedor f
            LEFT JOIN entrada e
                ON e.fornecedor_id = f.id
            LEFT JOIN item_entrada ie
                ON ie.entrada_id = e.id_entrada
            GROUP BY
                f.id,
                f.nome
            ORDER BY
                entradas DESC,
                f.nome ASC
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Entradas recentes
    public function entradasRecentes(): array
    {
        $sql = "
            SELECT
                e.id_entrada,
                f.nome AS fornecedor_nome,
                e.data,
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
                f.nome,
                e.data
            ORDER BY
                e.id_entrada DESC
            LIMIT 5
        ";

        return $this->conn->query($sql)->fetchAll();
    }

    // Estoque abaixo do mínimo
    public function estoqueBaixo(): array
    {
        $sql = "
            SELECT
                p.nome AS produto_nome,
                v.isbn AS sku,
                e.quantidade,
                e.minimo
            FROM estoque e
            INNER JOIN variacao v
                ON v.id_variacao = e.variacao_id
            INNER JOIN produto p
                ON p.id = v.produto_id
            WHERE e.quantidade < e.minimo
            ORDER BY
                e.quantidade ASC,
                p.nome ASC
        ";

        return $this->conn->query($sql)->fetchAll();
    }
}