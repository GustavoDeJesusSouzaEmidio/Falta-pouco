<?php
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Entradas - Entre Páginas Livraria</title>

    <link rel="icon" type="image/png"
          href="/entre_paginas/public/assets/favicon.png">

    <link rel="stylesheet"
          href="/entre_paginas/public/assets/css/dashboard.css">

    <style>
        .entrada-formulario {
            margin-bottom: 20px;
        }

        .entrada-campo {
            margin-bottom: 16px;
        }

        .entrada-campo label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #3b1a0d;
        }

        .entrada-campo select,
        .entrada-campo input {
            width: 100%;
            max-width: 600px;
            padding: 8px 10px;
            background-color: #fff;
            border: 1px solid #A07060;
            border-radius: 8px;
            color: #3b1a0d;
            font-family: inherit;
            font-size: 0.85rem;
            outline: none;
            box-sizing: border-box;
        }

        .entrada-campo select:focus,
        .entrada-campo input:focus {
            border-color: #6B3A2A;
        }

        .item-entrada {
            background-color: #E8D5C0;
            border: 1px solid #A07060;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 15px;
            max-width: 700px;
        }

        .item-entrada-titulo {
            font-size: 0.95rem;
            font-weight: 700;
            color: #3b1a0d;
            margin-bottom: 14px;
        }

        .botoes-entrada {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
        }

        .botao-entrada {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            font-family: inherit;
        }

        .botao-adicionar {
            background-color: transparent;
            border: 1px solid #A07060;
            color: #3b1a0d;
        }

        .botao-adicionar:hover {
            background-color: #D6B49A;
        }

        .botao-confirmar {
            background-color: #3b1a0d;
            border: 1px solid #ebc7bc;
            color: #ebc7bc;
        }

        .botao-confirmar:hover {
            background-color: #6B3A2A;
        }

        .tabela-entradas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabela-entradas th {
            background-color: #3b1a0d;
            color: #ebc7bc;
            padding: 10px;
            text-align: left;
            font-size: 0.8rem;
        }

        .tabela-entradas td {
            padding: 10px;
            border-bottom: 1px solid #D6B49A;
            color: #3b1a0d;
            font-size: 0.8rem;
        }

        .tabela-entradas tr:last-child td {
            border-bottom: none;
        }

        .status-confirmada {
            color: #3b1a0d;
            font-weight: bold;
        }

        .valor-total {
            font-weight: bold;
        }

        .sem-entradas {
            padding: 15px;
            color: #6B3A2A;
            text-align: center;
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
                <a href="/entre_paginas/index.php?controller=dashboard&action=index">
                    Dashboard
                </a>
            </li>

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
                <a href="/entre_paginas/index.php?controller=entrada&action=nova"
                   class="active">
                    Entradas
                </a>
            </li>

        </ul>

        <a href="/entre_paginas/index.php?controller=auth&action=logout"
           class="botao-sair">
            Sair
        </a>

    </aside>


    <main class="principal">

        <h1>Registrar Nova Entrada</h1>


        <div class="painel entrada-formulario">

            <h2>Nova Entrada</h2>

            <form method="POST"
                  action="index.php?controller=entrada&action=store">

                <div class="entrada-campo">

                    <label for="fornecedor_id">
                        Fornecedor
                    </label>

                    <select name="fornecedor_id"
                            id="fornecedor_id"
                            required>

                        <option value="">
                            Selecione
                        </option>

                        <?php foreach ($fornecedores as $fornecedor): ?>

                            <option value="<?= (int)$fornecedor['id'] ?>">
                                <?= htmlspecialchars($fornecedor['nome']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <h2 style="margin-bottom: 15px;">
                    Itens da Entrada
                </h2>


                <div id="itens">

                    <div class="item-entrada">

                        <div class="item-entrada-titulo">
                            Item 1
                        </div>


                        <div class="entrada-campo">

                            <label>
                                Variação / SKU
                            </label>

                            <select
                                name="itens[0][variacao_id]"
                                required>

                                <option value="">
                                    Selecione
                                </option>

                                <?php foreach ($variacoes as $variacao): ?>

                                    <option
                                        value="<?= (int)$variacao['id_variacao'] ?>"
                                        data-custo="<?= htmlspecialchars($variacao['preco_custo']) ?>"
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


                        <div class="entrada-campo">

                            <label>
                                Quantidade
                            </label>

                            <input
                                type="number"
                                name="itens[0][quantidade]"
                                min="1"
                                required
                            >

                        </div>


                        <div class="entrada-campo">

                            <label>
                                Custo Unitário (R$)
                            </label>

                            <input
                                type="number"
                                name="itens[0][custo_unitario]"
                                min="0"
                                step="0.01"
                                value="0.00"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="botoes-entrada">

                    <button
                        type="button"
                        class="botao-entrada botao-adicionar"
                        onclick="adicionarItem()">

                        + Adicionar Item

                    </button>


                    <button
                        type="submit"
                        class="botao-entrada botao-confirmar">

                        Confirmar Entrada

                    </button>

                </div>

            </form>

        </div>


        <div class="painel">

            <h2>Últimas Entradas</h2>

            <div style="overflow-x:auto;">

                <table class="tabela-entradas">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Fornecedor</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Valor Total</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($entradas)): ?>

                            <?php foreach ($entradas as $entrada): ?>

                                <tr>

                                    <td>
                                        #<?= (int)$entrada['id_entrada'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($entrada['fornecedor_nome']) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($entrada['data'])
                                        ) ?>
                                    </td>

                                    <td class="status-confirmada">
                                        Confirmada
                                    </td>

                                    <td class="valor-total">
                                        R$
                                        <?= number_format(
                                            (float)$entrada['valor_total'],
                                            2,
                                            ',',
                                            '.'
                                        ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="5"
                                    class="sem-entradas">

                                    Nenhuma entrada registrada.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>


<script>

let contador = 1;


function adicionarItem()
{
    const itens = document.getElementById('itens');

    const item = document.createElement('div');

    item.className = 'item-entrada';

    item.innerHTML = `

        <div class="item-entrada-titulo">
            Item ${contador + 1}
        </div>


        <div class="entrada-campo">

            <label>
                Variação / SKU
            </label>

            <select
                name="itens[${contador}][variacao_id]"
                required>

                <option value="">
                    Selecione
                </option>

                <?php foreach ($variacoes as $variacao): ?>

                    <option
                        value="<?= (int)$variacao['id_variacao'] ?>"
                        data-custo="<?= htmlspecialchars($variacao['preco_custo']) ?>"
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


        <div class="entrada-campo">

            <label>
                Quantidade
            </label>

            <input
                type="number"
                name="itens[${contador}][quantidade]"
                min="1"
                required
            >

        </div>


        <div class="entrada-campo">

            <label>
                Custo Unitário (R$)
            </label>

            <input
                type="number"
                name="itens[${contador}][custo_unitario]"
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
 * Preenche automaticamente o custo unitário
 * quando uma variação é selecionada.
 */
document.addEventListener('change', function(event)
{
    if (!event.target.matches('select[name$="[variacao_id]"]')) {
        return;
    }

    const select = event.target;

    const opcao = select.options[select.selectedIndex];

    const custo = opcao.getAttribute('data-custo');

    const item = select.closest('.item-entrada');

    if (!item) {
        return;
    }

    const campoCusto = item.querySelector(
        'input[name$="[custo_unitario]"]'
    );

    if (campoCusto && custo !== null) {
        campoCusto.value = custo;
    }
});

</script>

</body>
</html>