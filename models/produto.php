<?php
require_once __DIR__ . '/../config/db.php';

class Produto
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /**
     * Lista produtos com dados de categoria, gênero, preço e estoque.
     *
     * @param bool $somenteAtivos Se true, traz só produtos e categorias ativas.
     * @param int|null $idGenero Se informado, filtra pelo id_genero salvo na
     *                           tabela livro (ex: 2 = Romance).
     */
    public function listarComCategoria(bool $somenteAtivos = false, ?int $idGenero = null): array
    {
        $sql = "
            SELECT p.id, p.categoria_id, p.nome, p.descricao,
                   p.ativo, c.nome AS categoria_nome,
                   l.preco,
                   COALESCE(SUM(e.quantidade), 0) AS estoque,
                   l.id_genero
            FROM produto p
            INNER JOIN categoria c ON c.id = p.categoria_id
            LEFT JOIN livro l ON l.id_livro = p.id
            LEFT JOIN variacao v ON v.produto_id = p.id
            LEFT JOIN estoque e ON e.variacao_id = v.id_variacao
            WHERE 1 = 1
        ";

        $params = [];

        if ($somenteAtivos) {
            $sql .= " AND p.ativo = 1 AND c.ativo = 1 ";
        }

        if ($idGenero !== null) {
            $sql .= " AND l.id_genero = :id_genero ";
            $params[':id_genero'] = $idGenero;
        }

        $sql .= "
            GROUP BY
                p.id,
                p.categoria_id,
                p.nome,
                p.descricao,
                p.ativo,
                c.nome,
                l.preco,
                l.id_genero
            ORDER BY p.id DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT
                p.*,
                l.preco,
                COALESCE(SUM(e.quantidade), 0) AS estoque,
                l.id_genero
            FROM produto p
            LEFT JOIN livro l
                ON l.id_livro = p.id
            LEFT JOIN variacao v
                ON v.produto_id = p.id
            LEFT JOIN estoque e
                ON e.variacao_id = v.id_variacao
            WHERE p.id = :id
            GROUP BY
                p.id,
                l.preco,
                l.id_genero
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        $r = $stmt->fetch();

        return $r ?: null;
    }

    public function inserir(int $categoriaId, string $nome, ?string $descricao): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO produto (categoria_id, nome, descricao, ativo)
            VALUES (:categoria_id, :nome, :descricao, 1)
        ");

        $stmt->execute([
            ':categoria_id' => $categoriaId,
            ':nome'         => $nome,
            ':descricao'    => $descricao
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function atualizar(int $id, int $categoriaId, string $nome, ?string $descricao): void
    {
        $stmt = $this->conn->prepare("
            UPDATE produto
            SET categoria_id = :categoria_id,
                nome = :nome,
                descricao = :descricao
            WHERE id = :id
        ");

        $stmt->execute([
            ':id'           => $id,
            ':categoria_id' => $categoriaId,
            ':nome'         => $nome,
            ':descricao'    => $descricao
        ]);
    }

    public function setAtivo(int $id, bool $ativo): void
    {
        $stmt = $this->conn->prepare("
            UPDATE produto
            SET ativo = :ativo
            WHERE id = :id
        ");

        $stmt->execute([
            ':id'    => $id,
            ':ativo' => $ativo ? 1 : 0
        ]);
    }

    public function deletar(int $id): bool
    {
        $stmt = $this->conn->prepare("
            DELETE FROM produto
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}