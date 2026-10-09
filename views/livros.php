
<?php
// Localiza a capa pelo ID do produto.
if (!function_exists('imagemProdutoUrl')) {
    function imagemProdutoUrl(int $produtoId): string
    {
        $pasta = __DIR__ . '/../public/uploads/produtos/';
        $url = '/entre_paginas/public/uploads/produtos/';

        foreach (['jpg', 'png', 'webp'] as $ext) {
            if (file_exists($pasta . $produtoId . '.' . $ext)) {
                return $url . $produtoId . '.' . $ext;
            }
        }

        return '/entre_paginas/public/assets/img/livro_sem_capa.png';
    }
}

$livros = $livros ?? [];
$categorias = $categorias ?? [];
$pesquisa = trim($_GET['busca'] ?? '');

if ($pesquisa !== '') {
    $livros = array_values(array_filter($livros, function ($livro) use ($pesquisa) {
        return stripos($livro['nome'] ?? '', $pesquisa) !== false;
    }));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">
    <title><?= htmlspecialchars($tituloCatalogo ?? 'Nosso catálogo', ENT_QUOTES, 'UTF-8') ?> - Entre Páginas</title>
    <link rel="stylesheet" href="/entre_paginas/public/assets/css/livros.css">

    <style>
        .hero {
            background-image: url("/entre_paginas/public/assets/fundo2.png");
        }

        .busca-livros {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 28px auto;
            padding: 0 20px;
        }

        .busca-livros input {
            width: min(420px, 100%);
            padding: 12px 15px;
            border: 1px solid #b58a70;
            border-radius: 8px;
            font-size: 16px;
        }

        .busca-livros button {
            padding: 12px 20px;
            border: 0;
            border-radius: 8px;
            background: #62241b;
            color: #fff;
            cursor: pointer;
        }

        .vitrine {
            padding: 20px 40px 45px;
        }

        .vitrine .section-title {
            margin-left: 0;
        }

        .livros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 28px 20px;
            justify-items: center;
        }

        .livros {
            width: 100%;
            max-width: 180px;
            padding: 12px;
            border-radius: 12px;
            background: #FFE7D7;
            transition: transform .2s ease;
            color: inherit;
            text-decoration: none;
        }

        .livros:hover {
            transform: translateY(-4px);
        }

        .capa {
            width: 100%;
            height: 220px;
        }

        .capa img {
            max-width: 100%;
            width: 145px;
            height: 210px;
            object-fit: contain;
        }

        .titulo {
            min-height: 38px;
            font-weight: 600;
        }

        .preco {
            margin-top: 4px;
        }

        .sem-livros {
            text-align: center;
            padding: 25px;
            color: #62241b;
        }

        @media (max-width: 600px) {
            .hero {
                margin: 15px;
            }

            .section {
                padding: 20px 15px 0;
            }

            .generos-grid {
                justify-content: center;
            }

            .genero-livros img {
                width: 95px;
                height: 95px;
            }

            .vitrine {
                padding: 20px 15px 35px;
            }

            nav {
                padding: 10px 15px;
            }

            .logo {
                width: 130px;
                height: auto;
            }

            .nav-direita {
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <img src="/entre_paginas/public/assets/logo22.png"
             alt="Entre Páginas" class="logo">

        <div class="nav-direita">
            <span class="nome-usuario">
                Olá, <?= htmlspecialchars($_SESSION['nome'] ?? 'Cliente', ENT_QUOTES, 'UTF-8') ?>!
            </span>

            <?php if (($_SESSION['perfil'] ?? '') === 'admin'): ?>
                <a class="nav-icone"
                   href="/entre_paginas/index.php?controller=dashboard&action=index"
                   title="Painel administrativo">
                    <img src="/entre_paginas/public/assets/grafico1.png"
                         alt="Painel administrativo" class="dashboard">
                </a>
            <?php endif; ?>

            <a class="nav-icone"
               href="/entre_paginas/index.php?controller=auth&action=logout"
               title="Sair">
                <img src="/entre_paginas/public/assets/usuario.png"
                     alt="Sair" class="perfil-vendedor">
            </a>
        </div>
    </nav>

    <div class="hero">
        <h2>Boas histórias<br>te esperam aqui.</h2>
        <p>Descubra novos mundos, vilões e<br>heróis.</p>
    </div>

    <div class="section" style="margin-top: 24px;">
        <div class="generos-grid">
            <a class="genero-livros"
               href="/entre_paginas/index.php?controller=genero&action=index&genero=romance">
                <div class="romance">
                    <img src="/entre_paginas/public/assets/romance.png" alt="Romance">
                </div>
                <span class="genero-nome">romance</span>
            </a>

            <a class="genero-livros"
               href="/entre_paginas/index.php?controller=genero&action=index&genero=estudos">
                <div class="estudos">
                    <img src="/entre_paginas/public/assets/estudos.png" alt="Estudos">
                </div>
                <span class="genero-nome">estudos</span>
            </a>

            <a class="genero-livros"
               href="/entre_paginas/index.php?controller=genero&action=index&genero=teologico">
                <div class="teologico">
                    <img src="/entre_paginas/public/assets/teologico.png" alt="Teológico">
                </div>
                <span class="genero-nome">teológico</span>
            </a>

            <a class="genero-livros"
               href="/entre_paginas/index.php?controller=genero&action=index&genero=fantasia">
                <div class="fantasia">
                    <img src="/entre_paginas/public/assets/fantasia.png" alt="Fantasia">
                </div>
                <span class="genero-nome">fantasia</span>
            </a>

            <a class="genero-livros"
               href="/entre_paginas/index.php?controller=genero&action=index&genero=suspense">
                <div class="suspense">
                    <img src="/entre_paginas/public/assets/suspense.png" alt="Suspense">
                </div>
                <span class="genero-nome">suspense</span>
            </a>

            <a class="genero-livros"
               href="/entre_paginas/index.php?controller=genero&action=index&genero=terror">
                <div class="terror">
                    <img src="/entre_paginas/public/assets/terror.png" alt="Terror">
                </div>
                <span class="genero-nome">terror</span>
            </a>
        </div>
    </div>

    <form class="busca-livros" method="GET"
          action="/entre_paginas/index.php">
        <input type="hidden" name="controller" value="livros">
        <input type="hidden" name="action" value="index">

        <input type="search" name="busca"
               placeholder="Pesquisar livro pelo nome..."
               value="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>">

        <button type="submit">Pesquisar</button>
    </form>

    <section class="vitrine">
        <h1 class="section-title">
            <?= htmlspecialchars($tituloCatalogo ?? 'Nosso catálogo', ENT_QUOTES, 'UTF-8') ?>
        </h1>

        <?php if (empty($livros)): ?>
            <p class="sem-livros">Nenhum livro encontrado.</p>
        <?php else: ?>
            <div class="livros-grid">
                <?php foreach ($livros as $livro): ?>
                    <a class="livros"
                       href="/entre_paginas/index.php?controller=loja&action=detalhe&id=<?= (int)$livro['id'] ?>">

                        <div class="capa">
                            <img
                                src="<?= htmlspecialchars(imagemProdutoUrl((int)$livro['id']), ENT_QUOTES, 'UTF-8') ?>"
                                alt="Capa de <?= htmlspecialchars($livro['nome'], ENT_QUOTES, 'UTF-8') ?>"
                                loading="lazy">
                        </div>

                        <span class="titulo">
                            <?= htmlspecialchars($livro['nome'], ENT_QUOTES, 'UTF-8') ?>
                        </span>

                        <span class="preco">
                            R$ <?= is_numeric($livro['preco'] ?? null)
                                ? number_format((float)$livro['preco'], 2, ',', '.')
                                : '—' ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</body>
</html>