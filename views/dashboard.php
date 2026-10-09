<?php
// session já iniciada pelo index.php
$nome   = $_SESSION['nome']   ?? 'Usuário';
$perfil = $_SESSION['perfil'] ?? 'vendedor';


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - entre_paginas</title>
  <link rel="stylesheet" href="/entre_paginas/public/assets/css/dashboard.css?v=3">
  <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">
  <style>
    
  </style>
</head>
<body>

<!-- HEADER -->
<nav>
  <img src="/entre_paginas/public/assets/logo22.png" alt="entre_paginas" class="logo">
  <div class="nav-direita">

    <span class="nome-usuario">
      Olá, <?= htmlspecialchars($nome) ?>!
    </span>

    <a class="nav-icone" href="/entre_paginas/index.php?controller=dashboard&action=index">
      <img src="/entre_paginas/public/assets/grafico1.png" alt="dashboard" style="height:25px;width:25px;">
    </a>
    <a class="nav-icone" href="/entre_paginas/index.php?controller=auth&action=logout">
      <img src="/entre_paginas/public/assets/usuario.png" alt="perfil" style="height:25px;width:25px;">
    </a>
  </div>
</nav>

<div class="layout">

  <!-- MENU LATERAL -->
  <aside class="lateral">
    <ul class="nav-lateral">
      <li><a href="/entre_paginas/index.php?controller=dashboard&action=index" class="active">
        <img src="/entre_paginas/public/assets/casa.png" alt="dashboard" style="height:14px;width:14px;"> Dashboard
      </a></li>
      <li><a href="/entre_paginas/index.php?controller=produto&action=index">Livros</a></li>
      <li><a href="/entre_paginas/index.php?controller=fornecedor&action=index">Fornecedores</a></li>
      <li><a href="/entre_paginas/index.php?controller=entrada&action=nova">Entradas</a></li>
      <li><a href="/entre_paginas/index.php?controller=venda&action=nova">Vendas</a></li>
      

      <li><a href="#" class="active">
        <img src="/entre_paginas/public/assets/livro-icon.png" alt="generos" style="height:14px;width:14px;"> Gêneros Literários
      </a></li>

      <li><a href="/entre_paginas/index.php?controller=produto&action=catalogo&genero=Romance&id_genero=2">Romance</a></li>
      <li><a href="/entre_paginas/index.php?controller=produto&action=catalogo&genero=Estudos&id_genero=5">Estudos</a></li>
      <li><a href="/entre_paginas/index.php?controller=produto&action=catalogo&genero=Teol%C3%B3gico&id_genero=6">Teológico</a></li>
      <li><a href="/entre_paginas/index.php?controller=produto&action=catalogo&genero=Fantasia&id_genero=4">Fantasia</a></li>
      <li><a href="/entre_paginas/index.php?controller=produto&action=catalogo&genero=Suspense&id_genero=3">Suspense</a></li>
      <li><a href="/entre_paginas/index.php?controller=produto&action=catalogo&genero=Terror&id_genero=1">Terror</a></li>
    </ul>
    <a href="/entre_paginas/index.php?controller=auth&action=logout" class="botao-sair">Sair</a>
  </aside>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="principal">

    <!-- INDICADORES -->
    <div class="indicadores">
      <div class="indicadores-card">
        <span class="indicadores-icon"><img src="/entre_paginas/public/assets/livro-icon.png" alt="livros"></span>
        <div class="indicadores-infos">
          <span class="indicadores-titulo">Total de livros</span>
          <span class="indicadores-valor"><?php echo $totalLivros; ?></span>
        </div>
      </div>
      <div class="indicadores-card">
        <span class="indicadores-icon"><img src="/entre_paginas/public/assets/clientes.png" alt="clientes"></span>
        <div class="indicadores-infos">
          <span class="indicadores-titulo">Total de clientes</span>
          <span class="indicadores-valor"><?php echo $totalClientes; ?></span>
        </div>
      </div>
      <div class="indicadores-card">
        <span class="indicadores-icon"><img src="/entre_paginas/public/assets/moeda.png" alt="faturamento"></span>
        <div class="indicadores-infos">
          <span class="indicadores-titulo">Faturamento do mês</span>
          <span class="indicadores-valor">R$ <?php echo number_format($faturamentoMes, 2, ',', '.'); ?></span>
        </div>
      </div>
    </div>

    <!-- LINHA DO MEIO: ESTOQUE + PEDIDOS -->
    <div class="central">

      <!-- ESTOQUE -->
      <div class="painel">
        <div class="painel-titulo">
          <img src="/entre_paginas/public/assets/produtos.png" alt="estoque"> Resumo de estoque
        </div>
        <div class="estoque-status">
          <div class="estoque-item">
            <span class="estoque-icon"><img src="/entre_paginas/public/assets/livro-icon.png" alt="em-estoque"></span>
            <span class="estoque-disponibilidade">Em estoque</span>
            <span class="estoque-valor"><?php echo $emEstoque; ?></span>
          </div>
          <div class="estoque-item">
            <span class="estoque-icon"><img src="/entre_paginas/public/assets/aviso.png" alt="estoque-baixo"></span>
            <span class="estoque-disponibilidade">Estoque baixo</span>
            <span class="estoque-valor"><?php echo $estoqueBaixo; ?></span>
          </div>
          <div class="estoque-item">
            <span class="estoque-icon"><img src="/entre_paginas/public/assets/proibido.png" alt="esgotados"></span>
            <span class="estoque-disponibilidade">Esgotados</span>
            <span class="estoque-valor"><?php echo $esgotados; ?></span>
          </div>
        </div>
      </div>

      <!-- PEDIDOS RECENTES -->
      <div class="painel">
        <div class="header-pedidos">
          <div class="painel-titulo" style="margin-bottom:0;">
            <img src="/entre_paginas/public/assets/carrinho.png" alt="pedidos"> Pedidos recentes
          </div>
          
        </div>
        <div class="tabela-pedidos-header">
          <span>Pedido</span>
          <span>Cliente</span>
          <span>Data</span>
          <span>Status</span>
          <span>Total</span>
        </div>
        <?php if (empty($pedidosRecentes)): ?>
          <div class="pedidos">Nenhum pedido ainda.</div>
        <?php else: ?>
          <?php foreach ($pedidosRecentes as $pedido): ?>
            <div class="tabela-pedidos-linha">
              <span>#<?php echo $pedido['id_venda']; ?></span>
              <span><?php echo htmlspecialchars($pedido['cliente']); ?></span>
              <span><?php echo date('d/m/Y', strtotime($pedido['data'])); ?></span>
              <span><span class="tag-status">Concluído</span></span>
              <span>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div>

    <!-- GRÁFICO (largura total) -->
    <div class="painel painel-grafico">
      <div class="grafico-header">
        <div class="painel-titulo">
          <img src="/entre_paginas/public/assets/grafico1.png" alt="vendas"> Vendas dos últimos meses
        </div>
        <a href="/entre_paginas/index.php?controller=relatorio&action=index" class="grafico-link">ver ano →</a>
      </div>
      <div class="grafico-linhas">
        <?php
        $vendasPorMes = [];
        foreach ($vendasMeses as $v) {
            $vendasPorMes[$v['mes']] = $v['total'];
        }
        for ($i = 5; $i >= 0; $i--):
            $ts     = strtotime("-$i months");
            $mesNum = date('n', $ts);
            $mesPt  = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'][$mesNum - 1];
            $mesEn  = date('M', $ts);
            $total   = $vendasPorMes[$mesPt] ?? $vendasPorMes[$mesEn] ?? 0;
            $largura = $maxVenda > 0 ? round(($total / $maxVenda) * 100) : 0;
        ?>
          <div class="grafico-linha-item">
            <span class="grafico-mes"><?php echo $mesPt; ?></span>
            <div class="grafico-linha-barra">
              <div class="grafico-linha-preenchimento" style="width:<?php echo $largura; ?>%"></div>
            </div>
          </div>
        <?php endfor; ?>
      </div>
    </div>

  </main>
</div>

</body>
</html>