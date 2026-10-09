
<!doctype html>
<html lang="pt-br">
<head>
    <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">
    <meta charset="utf-8">
    <title>Entrar - Entre Páginas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/assets/css/login.css">
</head>
<body>
<div class="body">
    <div class="card">
        <div class="logo">
            <img src="public/assets/logo11.png" alt="Logo Entre Páginas" class="logo">
        </div>

        <form method="post" action="/entre_paginas/index.php?controller=auth&action=login">

            <h1 class="h1">
                <?php if ($tipo === 'admin'): ?>
                    Entrar como administrador
                <?php elseif ($tipo === 'cliente'): ?>
                    Entrar como cliente
                <?php else: ?>
                    Entre na sua conta
                <?php endif; ?>
            </h1>

            <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?>">

            <div class="dados">
                <input
                    type="email"
                    name="email"
                    required
                    autocomplete="username"
                    placeholder="E-mail">
            </div>

            <div class="dados">
                <input
                    type="password"
                    name="senha"
                    required
                    autocomplete="current-password"
                    placeholder="Senha">
            </div>

            <button class="entrar" type="submit">Entrar</button>

            <div class="rodape-abas">
                <?php if ($tipo !== 'admin'): ?>
                    <a href="index.php?controller=usuario&action=create">Criar conta de cliente</a>
                    <span class="dot">•</span>
                <?php endif; ?>

                <a href="/entre_paginas/">
                    <img src="public/assets/casa.png" alt="Início" class="casa">
                </a>
            </div>

        </form>
    </div>
</div>
</body>
</html>