
<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Categoria.php';

class LojaController
{
    private function verificarCliente(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=auth&action=form');
            exit;
        }

        if (!in_array($_SESSION['perfil'] ?? '', ['cliente', 'admin'], true)) {
            http_response_code(403);
            die('Acesso negado.');
        }
    }

    public function index(): void
    {
        $this->verificarCliente();

        $produtoModel = new Produto();
        $categoriaModel = new Categoria();

        $livros = $produtoModel->listarComCategoria(true);
        $categorias = $categoriaModel->listarAtivas();

        require __DIR__ . '/../views/livros.php';
    }

    public function detalhe(): void
    {
        $this->verificarCliente();

        $id = (int)($_GET['id'] ?? 0);
        $produtoModel = new Produto();
        $livro = $produtoModel->buscarPorId($id);

        if (!$livro || (int)$livro['ativo'] !== 1) {
            http_response_code(404);
            die('Livro não encontrado ou indisponível.');
        }

        require __DIR__ . '/../views/detalheLivro.php';
    }

    public function adicionar(): void
    {
        $this->verificarCliente();

        $id = (int)($_POST['id'] ?? 0);
        $quantidade = max(1, (int)($_POST['quantidade'] ?? 1));

        $produtoModel = new Produto();
        $livro = $produtoModel->buscarPorId($id);

        if (!$livro || (int)$livro['ativo'] !== 1) {
            die('Livro indisponível.');
        }

        $estoque = (int)$livro['estoque'];
        $carrinho = $_SESSION['carrinho'] ?? [];
        $quantidadeAtual = (int)($carrinho[$id] ?? 0);

        if ($estoque < 1 || $quantidadeAtual + $quantidade > $estoque) {
            die('Quantidade indisponível no estoque.');
        }

        $carrinho[$id] = $quantidadeAtual + $quantidade;
        $_SESSION['carrinho'] = $carrinho;

        header('Location: index.php?controller=loja&action=carrinho');
        exit;
    }

    public function carrinho(): void
    {
        $this->verificarCliente();

        $carrinho = $_SESSION['carrinho'] ?? [];
        $itensCarrinho = [];
        $total = 0;

        $produtoModel = new Produto();

        foreach ($carrinho as $id => $quantidade) {
            $livro = $produtoModel->buscarPorId((int)$id);

            if (!$livro || (int)$livro['ativo'] !== 1) {
                continue;
            }

            $quantidade = (int)$quantidade;
            $preco = (float)$livro['preco'];
            $subtotal = $preco * $quantidade;

            $livro['quantidade_carrinho'] = $quantidade;
            $livro['subtotal'] = $subtotal;

            $itensCarrinho[] = $livro;
            $total += $subtotal;
        }

        require __DIR__ . '/../views/carrinho.php';
    }

    public function atualizar(): void
    {
        $this->verificarCliente();

        $id = (int)($_POST['id'] ?? 0);
        $quantidade = (int)($_POST['quantidade'] ?? 0);

        $carrinho = $_SESSION['carrinho'] ?? [];
        $produtoModel = new Produto();
        $livro = $produtoModel->buscarPorId($id);

        if (!$livro || (int)$livro['ativo'] !== 1) {
            unset($carrinho[$id]);
        } elseif ($quantidade <= 0) {
            unset($carrinho[$id]);
        } elseif ($quantidade <= (int)$livro['estoque']) {
            $carrinho[$id] = $quantidade;
        } else {
            die('Quantidade maior que o estoque disponível.');
        }

        $_SESSION['carrinho'] = $carrinho;

        header('Location: index.php?controller=loja&action=carrinho');
        exit;
    }

    public function remover(): void
    {
        $this->verificarCliente();

        $id = (int)($_POST['id'] ?? 0);
        $carrinho = $_SESSION['carrinho'] ?? [];

        unset($carrinho[$id]);
        $_SESSION['carrinho'] = $carrinho;

        header('Location: index.php?controller=loja&action=carrinho');
        exit;
    }
}