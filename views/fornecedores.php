<?php
$ehAdmin = ($_SESSION['perfil'] ?? '') === 'admin';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fornecedores - Entre Páginas Livraria</title>

    <link rel="icon" type="image/png"
          href="/entre_paginas/public/assets/favicon.png">

    <link rel="stylesheet"
          href="/entre_paginas/public/assets/css/dashboard.css">
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
                <a href="/entre_paginas/index.php?controller=fornecedor&action=index"
                   class="active">
                    Fornecedores
                </a>
            </li>

        </ul>

        <a href="/entre_paginas/index.php?controller=auth&action=logout"
           class="botao-sair">
            Sair
        </a>

    </aside>


    <main class="principal">

        <h1>Fornecedores</h1>


        <?php if ($ehAdmin): ?>

            <div class="painel">

                <h2>
                    <?= $editar
                        ? 'Editar fornecedor #' . (int)$editar['id']
                        : 'Cadastrar fornecedor'
                    ?>
                </h2>


                <form method="post"
                      action="/entre_paginas/index.php?controller=fornecedor&action=salvar">

                    <input type="hidden"
                           name="id"
                           value="<?= $editar ? (int)$editar['id'] : 0 ?>">


                    <p>
                        <label for="nome">Nome:</label><br>

                        <input type="text"
                               id="nome"
                               name="nome"
                               maxlength="100"
                               required
                               style="width: 400px;"
                               value="<?= $editar
                                   ? htmlspecialchars($editar['nome'])
                                   : ''
                               ?>">
                    </p>


                    <p>
                        <label for="cnpj">CNPJ:</label><br>

                        <input type="text"
                               id="cnpj"
                               name="cnpj"
                               maxlength="20"
                               required
                               style="width: 400px;"
                               value="<?= $editar
                                   ? htmlspecialchars($editar['cnpj'])
                                   : ''
                               ?>">
                    </p>


                    <p>
                        <label for="telefone">Telefone:</label><br>

                        <input type="text"
                               id="telefone"
                               name="telefone"
                               maxlength="20"
                               style="width: 400px;"
                               value="<?= $editar
                                   ? htmlspecialchars($editar['telefone'] ?? '')
                                   : ''
                               ?>">
                    </p>


                    <p>
                        <label for="email">E-mail:</label><br>

                        <input type="email"
                               id="email"
                               name="email"
                               maxlength="100"
                               style="width: 400px;"
                               value="<?= $editar
                                   ? htmlspecialchars($editar['email'] ?? '')
                                   : ''
                               ?>">
                    </p>


                    <p>
                        <label for="cep">CEP:</label><br>

                        <input type="text"
                               id="cep"
                               name="cep"
                               maxlength="9"
                               placeholder="00000-000"
                               style="width: 400px;"
                               value="<?= $editar
                                   ? htmlspecialchars($editar['cep'] ?? '')
                                   : ''
                               ?>">
                    </p>


                    <p>
                        <label for="endereco">Endereço:</label><br>

                        <input type="text"
                               id="endereco"
                               name="endereco"
                               maxlength="255"
                               style="width: 400px;"
                               value="<?= $editar
                                   ? htmlspecialchars($editar['endereco'] ?? '')
                                   : ''
                               ?>"
                               readonly>
                    </p>


                    <button type="submit"
                            style="
                                display: inline-block;
                                padding: 3px 15px;
                                background-color: #3b1a0d;
                                border: 1px solid #ebc7bc;
                                border-radius: 20px;
                                font-size: 0.8rem;
                                color: #ebc7bc;
                                cursor: pointer;
                            ">
                        <?= $editar ? 'Atualizar' : 'Cadastrar' ?>
                    </button>


                    <a href="/entre_paginas/index.php?controller=fornecedor&action=index"
                       style="
                           display: inline-block;
                           padding: 3px 15px;
                           background-color: transparent;
                           border: 1px solid #A07060;
                           border-radius: 20px;
                           font-size: 0.8rem;
                           color: #3b1a0d;
                           text-decoration: none;
                           cursor: pointer;
                       ">
                        Limpar
                    </a>

                </form>

            </div>

        <?php else: ?>

            <div class="painel">
                <p>
                    Você está visualizando os fornecedores em modo somente leitura.
                </p>
            </div>

        <?php endif; ?>


        <div class="painel">

            <h2>Lista de Fornecedores</h2>


            <div style="overflow-x:auto;">

                <table width="100%" border="1" cellpadding="10">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Telefone</th>
                            <th>Endereço</th>
                            <th>Status</th>

                            <?php if ($ehAdmin): ?>
                                <th>Ações</th>
                            <?php endif; ?>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($fornecedores as $f): ?>

                            <tr>

                                <td>
                                    #<?= (int)$f['id'] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($f['nome']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($f['cnpj']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($f['telefone'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($f['endereco'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= !empty($f['ativo']) ? 'Ativo' : 'Inativo' ?>
                                </td>


                                <?php if ($ehAdmin): ?>

                                    <td>

                                        <a href="/entre_paginas/index.php?controller=fornecedor&action=index&id=<?= (int)$f['id'] ?>"
                                           style="
                                               display: inline-block;
                                               padding: 3px 15px;
                                               background-color: #A07060;
                                               border: 1px solid #ebc7bc;
                                               border-radius: 20px;
                                               font-size: 0.8rem;
                                               color: #fff !important;
                                               text-decoration: none !important;
                                           ">
                                            Editar
                                        </a>


                                        <button
                                            class="botao-inativar"
                                            onclick="location.href='/entre_paginas/index.php?controller=fornecedor&action=toggle&id=<?= (int)$f['id'] ?>&ativo=<?= !empty($f['ativo']) ? 0 : 1 ?>'"
                                            style="
                                                display: inline-block;
                                                padding: 3px 15px;
                                                background-color: #8a2c22;
                                                border: 1px solid #ebc7bc;
                                                border-radius: 20px;
                                                font-size: 0.8rem;
                                                color: #fff !important;
                                                text-decoration: none !important;
                                            ">

                                            <?= !empty($f['ativo']) ? 'Inativar' : 'Ativar' ?>

                                        </button>

                                    </td>

                                <?php endif; ?>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>


<script>

const cepInput = document.getElementById('cep');
const enderecoInput = document.getElementById('endereco');

if (cepInput && enderecoInput) {

    cepInput.addEventListener('input', async function () {

        const cep = this.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            return;
        }

        try {

            const resposta = await fetch(
                '/entre_paginas/index.php?controller=cep&action=buscar&cep=' + cep
            );

            const dados = await resposta.json();

            if (!resposta.ok) {
                enderecoInput.value = '';
                return;
            }

            enderecoInput.value = dados.endereco || '';

        } catch (erro) {

            enderecoInput.value = '';

        }

    });

}

</script>

</body>
</html>