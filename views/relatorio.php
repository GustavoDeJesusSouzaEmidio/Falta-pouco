<?php
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Relatórios - Entre Páginas Livraria</title>

    <link rel="icon" type="image/png"
          href="/entre_paginas/public/assets/favicon.png">

    <link rel="stylesheet"
          href="/entre_paginas/public/assets/css/dashboard.css">

    <style>

        .relatorio-linha {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .relatorio-painel {
            min-width: 0;
        }

        .tabela-relatorio {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabela-relatorio th {
            background-color: #3b1a0d;
            color: #ebc7bc;
            padding: 10px;
            text-align: left;
            font-size: 0.8rem;
        }

        .tabela-relatorio td {
            padding: 10px;
            border-bottom: 1px solid #D6B49A;
            color: #3b1a0d;
            font-size: 0.8rem;
        }

        .tabela-relatorio tr:last-child td {
            border-bottom: none;
        }

        .valor-relatorio {
            font-weight: bold;
        }

        .quantidade-relatorio {
            font-weight: bold;
        }

        .alerta-relatorio {
            color: #8a2c22;
            font-weight: bold;
        }

        .sem-relatorio {
            padding: 15px;
            color: #6B3A2A;
            text-align: center;
        }

        .titulo-alerta {
            color: #8a2c22;
        }

        @media (max-width: 900px) {

            .relatorio-linha {
                grid-template-columns: 1fr;
            }

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
                <a href="/entre_paginas/index.php?controller=entrada&action=nova">
                    Entradas
                </a>
            </li>

            <li>
                <a href="/entre_paginas/index.php?controller=venda&action=nova">
                    Vendas
                </a>
            </li>

            <li>
                <a href="/entre_paginas/index.php?controller=relatorio&action=index"
                   class="active">
                    Relatórios
                </a>
            </li>

        </ul>


        <a href="/entre_paginas/index.php?controller=auth&action=logout"
           class="botao-sair">
            Sair
        </a>

    </aside>


    <main class="principal">

        <h1>Relatórios</h1>


        <!-- LINHA 1 -->

        <div class="relatorio-linha">


            <!-- PRODUTOS MAIS VENDIDOS -->

            <div class="painel relatorio-painel">

                <h2>Produtos mais vendidos</h2>

                <div style="overflow-x:auto;">

                    <table class="tabela-relatorio">

                        <thead>

                            <tr>

                                <th>
                                    Produto
                                </th>

                                <th>
                                    Qtde. vendida
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($produtosMaisVendidos)): ?>

                                <?php foreach ($produtosMaisVendidos as $produto): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars(
                                                $produto['produto_nome']
                                            ) ?>
                                        </td>

                                        <td class="quantidade-relatorio">

                                            <?= (int)$produto['quantidade_vendida'] ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="2"
                                        class="sem-relatorio">

                                        Nenhum produto vendido.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- FORNECEDORES -->

            <div class="painel relatorio-painel">

                <h2>Fornecedores</h2>

                <div style="overflow-x:auto;">

                    <table class="tabela-relatorio">

                        <thead>

                            <tr>

                                <th>
                                    Fornecedor
                                </th>

                                <th>
                                    Entradas
                                </th>

                                <th>
                                    Valor total
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($fornecedores)): ?>

                                <?php foreach ($fornecedores as $fornecedor): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars(
                                                $fornecedor['nome']
                                            ) ?>
                                        </td>

                                        <td class="quantidade-relatorio">

                                            <?= (int)$fornecedor['entradas'] ?>

                                        </td>

                                        <td class="valor-relatorio">

                                            R$
                                            <?= number_format(
                                                (float)$fornecedor['valor_total'],
                                                2,
                                                ',',
                                                '.'
                                            ) ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="3"
                                        class="sem-relatorio">

                                        Nenhum fornecedor cadastrado.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- LINHA 2 -->

        <div class="relatorio-linha">


            <!-- ENTRADAS RECENTES -->

            <div class="painel relatorio-painel">

                <h2>Entradas recentes</h2>

                <div style="overflow-x:auto;">

                    <table class="tabela-relatorio">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Fornecedor
                                </th>

                                <th>
                                    Data
                                </th>

                                <th>
                                    Valor
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($entradasRecentes)): ?>

                                <?php foreach ($entradasRecentes as $entrada): ?>

                                    <tr>

                                        <td>
                                            #<?= (int)$entrada['id_entrada'] ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $entrada['fornecedor_nome']
                                            ) ?>
                                        </td>

                                        <td>

                                            <?= date(
                                                'd/m/Y',
                                                strtotime($entrada['data'])
                                            ) ?>

                                        </td>

                                        <td class="valor-relatorio">

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

                                    <td colspan="4"
                                        class="sem-relatorio">

                                        Nenhuma entrada registrada.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- ESTOQUE BAIXO -->

            <div class="painel relatorio-painel">

                <h2 class="titulo-alerta">
                    Estoque baixo (⚠️ Atenção)
                </h2>

                <div style="overflow-x:auto;">

                    <table class="tabela-relatorio">

                        <thead>

                            <tr>

                                <th>
                                    Produto
                                </th>

                                <th>
                                    SKU
                                </th>

                                <th>
                                    Qtde.
                                </th>

                                <th>
                                    Mínimo
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($estoqueBaixo)): ?>

                                <?php foreach ($estoqueBaixo as $item): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item['produto_nome']
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item['sku']
                                            ) ?>
                                        </td>

                                        <td class="alerta-relatorio">

                                            <?= (int)$item['quantidade'] ?>

                                        </td>

                                        <td>

                                            <?= (int)$item['minimo'] ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="4"
                                        class="sem-relatorio">

                                        Nenhum item abaixo do estoque mínimo.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>