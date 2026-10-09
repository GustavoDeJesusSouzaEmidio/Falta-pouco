
<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Categoria.php';

class LivrosController
{
    public function index(): void
    {
        $produtoModel = new Produto();
        $categoriaModel = new Categoria();

        $livros = $produtoModel->listarComCategoria(true);
        $categorias = $categoriaModel->listarAtivas();

        require __DIR__ . '/../views/livros.php';
    }
}