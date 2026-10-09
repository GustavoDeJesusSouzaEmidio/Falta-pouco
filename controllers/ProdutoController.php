<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Categoria.php';

class ProdutoController
{
    public function index(): void
    {
        $this->check();

        $produtoModel   = new Produto();
        $categoriaModel = new Categoria();

        // Filtro opcional por gênero, vindo do menu lateral
        // (ex: index.php?controller=produto&action=index&id_genero=2)
        $idGenero = isset($_GET['id_genero']) ? (int)$_GET['id_genero'] : null;

        $produtos   = $produtoModel->listarComCategoria(false, $idGenero);
        $categorias = $categoriaModel->listarAtivas();
        $editar     = null;

        if (isset($_GET['id'])) {
            $editar = $produtoModel->buscarPorId((int)$_GET['id']);
        }

        require_once __DIR__ . '/../views/produtos.php';
    }

    // Vitrine pública de livros filtrada por gênero
    // index.php?controller=produto&action=catalogo&id_genero=2&genero=Romance
    public function catalogo(): void
    {
        $this->check();

        $idGenero = (int)($_GET['id_genero'] ?? 0);
        $genero   = trim($_GET['genero'] ?? '');

        $produtoModel = new Produto();

        // true = somente produtos e categorias ativas
        $livros = $idGenero > 0
            ? $produtoModel->listarComCategoria(true, $idGenero)
            : [];

        require_once __DIR__ . '/../views/livrosFiltro.php';
    }

    public function salvar(): void
    {
        $this->check();
        $this->onlyAdmin();

        $id          = (int)($_POST['id'] ?? 0);
        $categoriaId = (int)($_POST['categoria_id'] ?? 0);
        $nome        = trim($_POST['nome'] ?? '');
        $descricao   = trim($_POST['descricao'] ?? '');
        $preco       = (float)($_POST['preco'] ?? 0);
        $estoque     = (int)($_POST['estoque'] ?? 0);

        $descricao = $descricao === '' ? null : $descricao;

        if ($categoriaId <= 0 || $nome === '') {
            die("Dados inválidos.");
        }

        $produtoModel = new Produto();
        $db = Database::getConnection();

        if ($id > 0) {

            // Atualiza produto
            $produtoModel->atualizar(
                $id,
                $categoriaId,
                $nome,
                $descricao
            );

            $this->salvarImagemDoProduto($id);

            // Atualiza preço e estoque antigo na tabela livro
            $stmt = $db->prepare("
                UPDATE livro
                SET preco = ?,
                    titulo = ?,
                    quantidade_estoque = ?
                WHERE id_livro = ?
            ");

            $stmt->execute([
                $preco,
                $nome,
                $estoque,
                $id
            ]);

            // Encontra a variação do produto
            $stmt = $db->prepare("
                SELECT id_variacao
                FROM variacao
                WHERE produto_id = ?
                LIMIT 1
            ");

            $stmt->execute([$id]);

            $variacao = $stmt->fetch();

            // Atualiza também o estoque usado pelo sistema
            if ($variacao) {

                $variacaoId = (int)$variacao['id_variacao'];

                // Verifica se já existe estoque para essa variação
                $stmt = $db->prepare("
                    SELECT quantidade
                    FROM estoque
                    WHERE variacao_id = ?
                ");

                $stmt->execute([$variacaoId]);

                $estoqueExiste = $stmt->fetch();

                if ($estoqueExiste) {

                    // Atualiza estoque existente
                    $stmt = $db->prepare("
                        UPDATE estoque
                        SET quantidade = ?
                        WHERE variacao_id = ?
                    ");

                    $stmt->execute([
                        $estoque,
                        $variacaoId
                    ]);

                } else {

                    // Cria estoque caso ainda não exista
                    $stmt = $db->prepare("
                        INSERT INTO estoque
                            (variacao_id, quantidade)
                        VALUES
                            (?, ?)
                    ");

                    $stmt->execute([
                        $variacaoId,
                        $estoque
                    ]);
                }
            }

        } else {

            // Insere produto e pega ID
            $novoId = $produtoModel->inserir(
                $categoriaId,
                $nome,
                $descricao
            );

            $this->salvarImagemDoProduto($novoId);

            // Insere também na tabela livro com o mesmo ID
            $stmt = $db->prepare("
                INSERT INTO livro
                    (
                        id_livro,
                        titulo,
                        preco,
                        quantidade_estoque,
                        id_genero
                    )
                VALUES
                    (?, ?, ?, ?, NULL)
            ");

            $stmt->execute([
                $novoId,
                $nome,
                $preco,
                $estoque
            ]);
        }

        header("Location: index.php?controller=produto&action=index");
        exit;
    }

    public function toggle(): void
    {
        $this->check();
        $this->onlyAdmin();

        $id    = (int)($_GET['id'] ?? 0);
        $ativo = (int)($_GET['ativo'] ?? 1);

        if ($id <= 0) {
            die("ID inválido.");
        }

        $produtoModel = new Produto();

        $produtoModel->setAtivo(
            $id,
            $ativo === 1
        );

        header("Location: index.php?controller=produto&action=index");
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

        $produtoModel = new Produto();

        $produto = $produtoModel->buscarPorId($id);

        if (!$produto) {
            die("Produto não encontrado.");
        }

        $this->deletarImagemDoProduto($id);

        $produtoModel->deletar($id);

        // Remove também da tabela livro
        $db = Database::getConnection();

        $stmt = $db->prepare("
            DELETE FROM livro
            WHERE id_livro = ?
        ");

        $stmt->execute([$id]);

        header("Location: index.php?controller=produto&action=index");
        exit;
    }

    // -------------------------
    // Upload (POO + seguro)
    // -------------------------

    private function salvarImagemDoProduto(int $produtoId): void
    {
        if (
            !isset($_FILES['imagem']) ||
            $_FILES['imagem']['error'] !== UPLOAD_ERR_OK
        ) {
            return;
        }

        if (
            ($_FILES['imagem']['size'] ?? 0) >
            2 * 1024 * 1024
        ) {
            return;
        }

        $tmp  = $_FILES['imagem']['tmp_name'];
        $mime = mime_content_type($tmp);

        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            default      => null
        };

        if ($ext === null) {
            return;
        }

        $destDir = __DIR__ . '/../public/uploads/produtos/';

        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        foreach (['jpg', 'png', 'webp'] as $e) {

            $old = $destDir . $produtoId . '.' . $e;

            if (file_exists($old)) {
                unlink($old);
            }
        }

        $dest = $destDir . $produtoId . '.' . $ext;

        move_uploaded_file($tmp, $dest);
    }

    private function deletarImagemDoProduto(int $produtoId): void
    {
        $destDir = __DIR__ . '/../public/uploads/produtos/';

        foreach (['jpg', 'png', 'webp'] as $ext) {

            $arquivo = $destDir . $produtoId . '.' . $ext;

            if (file_exists($arquivo)) {
                unlink($arquivo);
            }
        }
    }

    private function check(): void
    {
        if (!isset($_SESSION['usuario_id'])) {

            header(
                "Location: index.php?controller=auth&action=form"
            );

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