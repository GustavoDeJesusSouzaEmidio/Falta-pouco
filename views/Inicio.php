
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entre Páginas</title>
    <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f0e8;
            color: #342820;
        }

        .painel {
            width: 100%;
            max-width: 430px;
            padding: 36px 28px;
            text-align: center;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 5px 22px #00000018;
        }

        .logo {
            width: 150px;
            max-width: 100%;
            object-fit: contain;
        }

        h1 {
            margin-bottom: 8px;
        }

        p {
            margin-bottom: 28px;
            color: #6d625a;
        }

        .botao {
            display: block;
            width: 100%;
            padding: 14px;
            margin-top: 14px;
            border: 1px solid #8a2c22;
            border-radius: 7px;
            background: #8a2c22;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .botao.admin {
            background: #fff;
            color: #8a2c22;
        }

        .botao:hover {
            opacity: 0.88;
        }
    </style>
</head>
<body>
    <main class="painel">
        <img
            src="/entre_paginas/public/assets/logo22.png"
            alt="Logo Entre Páginas"
            class="logo"
        >

        <h1>Entre Páginas</h1>
        <p>Como deseja acessar?</p>

        <a
            class="botao"
            href="index.php?controller=auth&action=form&tipo=cliente"
        >
            Entrar como cliente
        </a>

        <a
            class="botao admin"
            href="index.php?controller=auth&action=form&tipo=admin"
        >
            Entrar como administrador
        </a>
    </main>
</body>
</html>