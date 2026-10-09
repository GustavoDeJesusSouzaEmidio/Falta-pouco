
<?php

require_once __DIR__ . '/../models/Produto.php';

class GeneroController
{
    public function index(): void
    {
        $generos = [
            'terror' => 1,
            'romance' => 2,
            'suspense' => 3,
            'fantasia' => 4,
            'estudos' => 5,
            'teologico' => 6
        ];

        $nomes = [
            'terror' => 'Terror',
            'romance' => 'Romance',
            'suspense' => 'Suspense',
            'fantasia' => 'Fantasia',
            'estudos' => 'Estudos',
            'teologico' => 'Teologia'
        ];

        $genero = strtolower($_GET['genero'] ?? '');

        if (!isset($generos[$genero])) {
            http_response_code(404);
            die('Gênero não encontrado.');
        }

        $produtoModel = new Produto();

        $livros = $produtoModel->listarComCategoria(
            true,
            $generos[$genero]
        );

        $categorias = [];
        $tituloCatalogo = 'Livros de ' . $nomes[$genero];

        require __DIR__ . '/../views/livros.php';
    }
}