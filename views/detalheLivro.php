
<?php
if (!function_exists('imagemDetalheLivroUrl')) {
    function imagemDetalheLivroUrl(int $id): string
    {
        $pasta = __DIR__ . '/../public/uploads/produtos/';
        $url = '/entre_paginas/public/uploads/produtos/';

        foreach (['jpg', 'png', 'webp'] as $ext) {
            if (file_exists($pasta . $id . '.' . $ext)) {
                return $url . $id . '.' . $ext;
            }
        }

        return '/entre_paginas/public/assets/img/livro_sem_capa.png';
    }
}

if (!isset($livro) || !$livro) {
    die('Livro não encontrado.');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($livro['nome'], ENT_QUOTES, 'UTF-8') ?> - Entre Páginas</title>
    <link rel="stylesheet" href="/entre_paginas/public/assets/css/livros.css">
    <style>
        .detalhe-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 25px;
            display: flex;
            gap: 35px;
            align-items: flex-start;
            flex-wrap: wrap;
            background: #FFE7D7;
            border-radius: 15px;
        }
        .detalhe-capa {
            width: 230px;
            max-width: 100%;
            height: 330px;
            object-fit: contain;
        }
        .detalhe-info {
            flex: 1;
            min-width: 230px;
        }
        .detalhe-info h1 {
            color: #62241b;
            margin-bottom: 15px;
        }
        .detalhe-preco {
            font-size: 1.5rem;
            font-weight: bold;
            color: #62241b;
            margin: 20px 0;
        }
        .detalhe-info p {
            margin-bottom: 12px;
            line-height: 1.5;
        }
        .detalhe-info input {
            width: 85px;
            padding: 10px;
            margin: 10px 0;
        }
        .botao-comprar, .botao-voltar {
            display: inline-block;
            padding: 12px 18px;
            border: 0;
            border-radius: 8px;
            background: #62241b;
            color: white;
            text-decoration: none;
            cursor: pointer;
            margin: 5px 5px 5px 0;
        }
        .botao-voltar {
            background: #8a2c22;
        }
    </style>
</head>
<body>
    <nav>
        <img src="/entre_paginas/public/assets/logo22.png"
             alt="Entre Páginas" class="logo">

        <div class="nav-direita">
            <a class="botao-comprar"
               href="/entre_paginas/index.php?controller=loja&action=carrinho">
                Meu carrinho
            </a>
            <a class="botao-voltar"
               href="/entre_paginas/index.php?controller=loja&action=index">
                Voltar à loja
            </a>
        </div>
    </nav>

    <main class="detalhe-container">
        <img class="detalhe-capa"
             src="<?= htmlspecialchars(imagemDetalheLivroUrl((int)$livro['id']), ENT_QUOTES, 'UTF-8') ?>"
             alt="Capa de <?= htmlspecialchars($livro['nome'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="detalhe-info">
            <h1><?= htmlspecialchars($livro['nome'], ENT_QUOTES, 'UTF-8') ?></h1>

            <p>
                <?= nl2br(htmlspecialchars($livro['descricao'] ?? 'Conheça este livro do catálogo Entre Páginas.', ENT_QUOTES, 'UTF-8')) ?>
            </p>

            <p class="detalhe-preco">
                R$ <?= number_format((float)$livro['preco'], 2, ',', '.') ?>
            </p>

            <p>
                Estoque disponível: <?= (int)$livro['estoque'] ?>
            </p>

            <?php if ((int)$livro['estoque'] > 0): ?>
                <form method="POST"
                      action="/entre_paginas/index.php?controller=loja&action=adicionar">
                    <input type="hidden" name="id" value="<?= (int)$livro['id'] ?>">

                    <label for="quantidade">Quantidade:</label><br>
                    <input id="quantidade" type="number" name="quantidade"
                           min="1" max="<?= (int)$livro['estoque'] ?>"
                           value="1" required>

                    <br>
                    <button class="botao-comprar" type="submit">
                        Adicionar ao carrinho
                    </button>
                </form>
            <?php else: ?>
                <p>Livro indisponível no momento.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>