
<?php
if (!isset($itensCarrinho)) {
    $itensCarrinho = [];
}

if (!isset($total)) {
    $total = 0;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu carrinho - Entre Páginas</title>

    <link rel="stylesheet" href="/entre_paginas/public/assets/css/livros.css">

    <style>
        .carrinho-container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 25px;
        }

        .carrinho-container h1 {
            color: #62241b;
            margin-bottom: 25px;
        }

        .item-carrinho {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            padding: 20px;
            margin-bottom: 15px;
            background: #FFE7D7;
            border-radius: 12px;
        }

        .item-carrinho img {
            width: 90px;
            height: 120px;
            object-fit: contain;
        }

        .item-info {
            flex: 1;
            min-width: 180px;
        }

        .item-info h3 {
            color: #62241b;
            margin-top: 0;
        }

        .item-info p {
            margin: 8px 0;
        }

        .item-carrinho input {
            width: 70px;
            padding: 8px;
        }

        .botao {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 7px;
            background: #62241b;
            color: white;
            text-decoration: none;
            cursor: pointer;
            margin: 5px 5px 5px 0;
        }

        .botao-remover {
            background: #8a2c22;
        }

        .carrinho-total {
            text-align: right;
            font-size: 1.4rem;
            font-weight: bold;
            color: #62241b;
            margin: 25px 0;
        }
    </style>
</head>
<body>

    <nav>
        <img src="/entre_paginas/public/assets/logo22.png"
             alt="Entre Páginas" class="logo">
    </nav>

    <main class="carrinho-container">
        <h1>Meu carrinho</h1>

        <?php if (empty($itensCarrinho)): ?>

            <p>Seu carrinho está vazio.</p>

            <a class="botao"
               href="/entre_paginas/index.php?controller=loja&action=index">
                Voltar à loja
            </a>

        <?php else: ?>

            <?php foreach ($itensCarrinho as $item): ?>

                <section class="item-carrinho">
                    <div class="item-info">
                        <h3>
                            <?= htmlspecialchars($item['nome'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p>
                            Preço unitário:
                            R$ <?= number_format((float)$item['preco'], 2, ',', '.') ?>
                        </p>

                        <p>
                            Subtotal:
                            R$ <?= number_format((float)$item['subtotal'], 2, ',', '.') ?>
                        </p>

                        <p>
                            Estoque disponível: <?= (int)$item['estoque'] ?>
                        </p>
                    </div>

                    <form method="POST"
                          action="/entre_paginas/index.php?controller=loja&action=atualizar">

                        <input type="hidden" name="id"
                               value="<?= (int)$item['id'] ?>">

                        <label for="qtd-<?= (int)$item['id'] ?>">
                            Quantidade:
                        </label>

                        <input
                            id="qtd-<?= (int)$item['id'] ?>"
                            type="number"
                            name="quantidade"
                            min="0"
                            max="<?= (int)$item['estoque'] ?>"
                            value="<?= (int)$item['quantidade_carrinho'] ?>"
                            required
                        >

                        <button class="botao" type="submit">
                            Atualizar
                        </button>
                    </form>

                    <form method="POST"
                          action="/entre_paginas/index.php?controller=loja&action=remover">

                        <input type="hidden" name="id"
                               value="<?= (int)$item['id'] ?>">

                        <button class="botao botao-remover" type="submit">
                            Remover
                        </button>
                    </form>
                </section>

            <?php endforeach; ?>

            <div class="carrinho-total">
                Total: R$ <?= number_format((float)$total, 2, ',', '.') ?>
            </div>

            <a class="botao"
               href="/entre_paginas/index.php?controller=loja&action=index">
                Continuar comprando
            </a>

        <?php endif; ?>
    </main>

</body>
</html>