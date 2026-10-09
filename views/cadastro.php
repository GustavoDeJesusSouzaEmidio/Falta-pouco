
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/assets/css/cadastro.css">
    <title>Cadastrar Cliente - Entre Páginas</title>
    <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">
</head>
<body>

    <div class="card">

        <img src="public/assets/logo22.png" alt="Entre Páginas Livraria" class="logo">

        <form action="index.php?controller=usuario&action=store" method="POST" style="width: 100%;">

            <div class="dados">
                <p class="dados-texto">Nome completo</p>
                <input type="text" name="nome" placeholder="Digite seu nome completo" required>
            </div>

            <div class="spacer"></div>

            <div class="dados">
                <p class="dados-texto">CPF ou CNPJ</p>
                <input type="text" name="cpf_cnpj" placeholder="Digite seu CPF ou CNPJ" required>
            </div>

            <div class="spacer"></div>

            <div class="dados">
                <p class="dados-texto">E-mail</p>
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="spacer"></div>

            <div class="dados">
                <p class="dados-texto">Senha</p>
                <div class="dados-senha">
                    <input type="password" name="senha" placeholder="Crie uma senha" required>
                </div>
            </div>

            <div style="width: 100%; display: flex; justify-content: center;">
                <button type="submit" class="cadastrar">Criar conta</button>
            </div>

        </form>

        <div class="rodape-links">
            <a href="index.php?controller=auth&action=form">
                <img src="public/assets/casa.png" alt="">
                Voltar para entrar
            </a>
        </div>

    </div>

</body>
</html>