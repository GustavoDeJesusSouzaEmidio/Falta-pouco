<?php
// helper simples para resolver imagem por ID sem usar banco
// (protegido com function_exists caso este arquivo seja incluído
// junto com produtos.php, que já declara a mesma função)
if (!function_exists('imagemProdutoUrl')) {
    function imagemProdutoUrl(int $produtoId): string
    {
        $baseFs  = __DIR__ . "/../public/uploads/produtos/";
        $baseUrl = "public/uploads/produtos/";
        foreach (['jpg', 'png', 'webp'] as $ext) {
            if (file_exists($baseFs . $produtoId . '.' . $ext)) {
                return $baseUrl . $produtoId . '.' . $ext;
            }
        }
        return "public/assets/img/livro_sem_capa.png";
    }
}

// $genero e $livros vêm do controller (CatalogoController::index / ProdutoController::catalogo)
$tituloGenero = $genero !== '' ? ucfirst($genero) : 'Catálogo';
?><!DOCTYPE html><html lang="pt-BR">
  <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($tituloGenero) ?></title>  <link rel="stylesheet" href="public/assets/css/romance.css">
</head>
<body>  <nav>
    <img src="public/assets//logo22.png" alt="entre_paginas" class="logo">   <div class="nav-direita">
       <span class="nome-usuario">
         Olá, <?= htmlspecialchars($_SESSION['nome'] ?? 'Usuário') ?>!
       </span>   <a class="nav-icone" href="index.php?controller=dashboard&action=index">
    <img src="public/assets/grafico1.png" alt="dashboard" class="dashboard">
  </a>

  <a class="nav-icone" href="index.php?controller=auth&action=logout">
    <img src="public/assets/usuario.png" alt="vendedor" class="perfil-vendedor">
  </a>
</div>

  </nav>  <div class="catalogo">
    <div class="fundo">  <div class="catalogo-header">
    <h1 class="section-title"><?= htmlspecialchars($tituloGenero) ?></h1>
    <hr class="linha-titulo">

    <?php if (empty($livros)): ?>
      <p style="color:#FFE7D7; text-align:center;">Nenhum livro encontrado nesta categoria.</p>
    <?php else: ?>
      <div class="livros-grid">
        <?php foreach ($livros as $livro): ?>
          <a class="livros" href="index.php?controller=produto&action=index&id=<?= (int)$livro['id'] ?>">
            <div class="capa">
              <img src="<?= imagemProdutoUrl((int)$livro['id']) ?>" alt="<?= htmlspecialchars($livro['nome']) ?>">
            </div>
            <span class="titulo"><?= htmlspecialchars($livro['nome']) ?></span>
            <span class="preco">
              R$ <?= is_numeric($livro['preco']) ? number_format((float)$livro['preco'], 2, ',', '.') : '-' ?>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>

  </div></body>
</html>