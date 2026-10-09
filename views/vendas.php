<?php
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vendas - Entre Páginas Livraria</title>

    <link rel="icon" type="image/png"
          href="/entre_paginas/public/assets/favicon.png">

    <link rel="stylesheet"
          href="/entre_paginas/public/assets/css/dashboard.css">

    <style>
        .form-venda {
            max-width: 100%;
        }

        .campo-venda {
            margin-bottom: 20px;
        }

        .campo-venda label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .campo-venda select,
        .campo-venda input {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #A07060;
            border-radius: 6px;
        }

        .item-venda {
            border: 1px solid #A07060;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .titulo-itens {
            margin-top: 25px;
            margin-bottom: 20px;
        }

        .botoes-venda {
            margin-top: 20px;
        }

        .botao-venda {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .adicionar-item {
            background-color: transparent;
            border: 1px solid #A07060;
            color: #3b1a0d;
        }

        .finalizar-venda {
            background-color: #8a2c22;
            border: 1px solid #ebc7bc;
            color: #fff;
            margin-left: 8px;
        }

        .tabela-vendas {
            width: 100%;
            border-collapse: collapse;
        }

        .tabela-vendas th,
        .tabela-vendas td {
            padding: 10px;
            border: 1px solid #A07060;
            text-align: left;
        }

        .tabela-vendas th {
            font-weight: bold;
        }
    </style>
</head>

<body>

<nav>
    <img src="/entre_paginas/public/assets/logo22.png"
         alt="Entre Páginas"
         class="logo">

    <div class="nav-direita">

        <span class="nome-usuario">
            Olá, <?= htmlspecialchars($_SESSION['nome'] ?? 'Usuário') ?>!
        </span>

        <a href="/entre_paginas/index.php?controller=dashboard&action=index">
            <img src="/entre_paginas/public/assets/grafico1.png"
                 alt="Dashboard"
                 style="height:25px;width:25px;">
        </a>

        <a href="/entre_paginas/index.php?controller=auth&action=logout">
            <img src="/entre_paginas/public/assets/usuario.png"
                 alt="Sair"
                 style="height:25px;width:25px;">
        </a>

    </div>
</nav>

<div class="layout">

    <aside class="lateral">

        <ul class="nav-lateral">

            <li>
                <a href="/entre_paginas/index.php?controller=produto&action=index">
                    Livros
                </a>
            </li>

            <li>
                <a href="/entre_paginas/index.php?controller=fornecedor&action=index">
                    Fornecedores
                </a>
            </li>

            <li>
                <a href="/entre_paginas/index.php?controller=entrada&action=nova">
                    Entradas
                </a>
            </li>

            <li>
                <a href="/entre_paginas/index.php?controller=venda&action=nova"
                   class="active">
                    Vendas
                </a>
            </li>

        </ul>

        <a href="/entre_paginas/index.php?controller=auth&action=logout"
           class="botao-sair">
            Sair
        </a>

    </aside>

    <main class="principal">

        <h1>Nova Venda</h1>

        <?php if (isset($clientes) && isset($variacoes)): ?>

            <div class="painel">

                <form class="form-venda"
                      method="POST"
                      action="/entre_paginas/index.php?controller=venda&action=store">

                    <div class="campo-venda">

                        <label for="cliente_id">
                            Cliente
                        </label>

                        <select name="cliente_id"
                                id="cliente_id"
                                required>

                            <option value="">
                                Selecione
                            </option>

                            <?php foreach ($clientes as $cliente): ?>

                                <option value="<?= (int)$cliente['id'] ?>">
                                    <?= htmlspecialchars($cliente['nome']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <h2 class="titulo-itens">
                        Itens vendidos
                    </h2>

                    <div id="itens">

                        <div class="item-venda">

                            <div class="campo-venda">

                                <label>
                                    Variação (SKU)
                                </label>

                                <select name="itens[0][variacao_id]"
                                        required>

                                    <option value="">
                                        Selecione
                                    </option>

                                    <?php foreach ($variacoes as $variacao): ?>

                                        <option
                                            value="<?= (int)$variacao['id_variacao'] ?>"
                                            data-preco="<?= htmlspecialchars($variacao['preco_venda']) ?>"
                                        >
                                            <?= htmlspecialchars($variacao['produto_nome']) ?>
                                            - <?= htmlspecialchars($variacao['formato']) ?>
                                            - <?= htmlspecialchars($variacao['isbn']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <div class="campo-venda">

                                <label>
                                    Quantidade
                                </label>

                                <input
                                    type="number"
                                    name="itens[0][quantidade]"
                                    min="1"
                                    value="1"
                                    required
                                >

                            </div>

                            <div class="campo-venda">

                                <label>
                                    Preço Unitário (R$)
                                </label>

                                <input
                                    type="number"
                                    name="itens[0][preco_unitario]"
                                    min="0"
                                    step="0.01"
                                    value="0.00"
                                    required
                                >

                            </div>

                        </div>

                    </div>

                    <div class="botoes-venda">

                        <button
                            type="button"
                            class="botao-venda adicionar-item"
                            onclick="adicionarItem()">

                            + Adicionar Item

                        </button>

                        <button
                            type="submit"
                            class="botao-venda finalizar-venda">

                            Finalizar Venda

                        </button>

                    </div>

                </form>

            </div>

        <?php endif; ?>


        <?php if (isset($vendas)): ?>

            <div class="painel">

                <h2>Vendas Recentes</h2>

                <div style="overflow-x:auto;">

                    <table class="tabela-vendas">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Data</th>
                                <th>Valor Total</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($vendas as $venda): ?>

                                <tr>

                                    <td>
                                        #<?= (int)$venda['id_venda'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($venda['cliente_nome']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($venda['vendedor_nome']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($venda['data']) ?>
                                    </td>

                                    <td>
                                        R$
                                        <?= number_format(
                                            (float)$venda['valor_total'],
                                            2,
                                            ',',
                                            '.'
                                        ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        <?php endif; ?>

    </main>

</div>


<script>

let contador = 1;

function adicionarItem()
{
    const itens = document.getElementById('itens');

    const item = document.createElement('div');

    item.className = 'item-venda';

    item.innerHTML = `
        <div class="campo-venda">

            <label>
                Variação (SKU)
            </label>

            <select
                name="itens[${contador}][variacao_id]"
                required>

                <option value="">
                    Selecione
                </option>

                <?php foreach ($variacoes ?? [] as $variacao): ?>

                    <option
                        value="<?= (int)$variacao['id_variacao'] ?>"
                        data-preco="<?= htmlspecialchars($variacao['preco_venda']) ?>"
                    >
                        <?= htmlspecialchars($variacao['produto_nome']) ?>
                        - ISBN:
                        <?= htmlspecialchars($variacao['isbn']) ?>
                        -
                        <?= htmlspecialchars($variacao['formato']) ?>
                        -
                        <?= htmlspecialchars($variacao['edicao']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="campo-venda">

            <label>
                Quantidade
            </label>

            <input
                type="number"
                name="itens[${contador}][quantidade]"
                min="1"
                value="1"
                required
            >

        </div>


        <div class="campo-venda">

            <label>
                Preço Unitário (R$)
            </label>

            <input
                type="number"
                name="itens[${contador}][preco_unitario]"
                min="0"
                step="0.01"
                value="0.00"
                required
            >

        </div>
    `;

    itens.appendChild(item);

    contador++;
}


/*
 * Preenche automaticamente o preço
 * quando uma variação é selecionada.
 */
document.addEventListener('change', function (event) {

    if (event.target.matches('select[name$="[variacao_id]"]')) {

        const select = event.target;

        const opcao = select.options[select.selectedIndex];

        const preco = opcao.getAttribute('data-preco');

        const item = select.closest('.item-venda');

        const campoPreco = item.querySelector(
            'input[name$="[preco_unitario]"]'
        );

        if (campoPreco && preco !== null) {

            campoPreco.value = preco;

        }

    }

});

</script>

</body>
</html>