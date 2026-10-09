<?php
// helper simples para resolver imagem por ID sem usar banco
function imagemProdutoUrl(int $produtoId): string
{
    $baseFs  = __DIR__ . "/../public/uploads/produtos/";
    $baseUrl = "public/uploads/produtos/";
    foreach (['jpg', 'png', 'webp'] as $ext) {
        if (file_exists($baseFs . $produtoId . '.' . $ext)) {
            return $baseUrl . $produtoId . '.' . $ext;
        }
    }
    return "public/assets/img/produto_sem_foto.png";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <link rel="icon" type="image/png" href="/entre_paginas/public/assets/favicon.png">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Produtos</title>

  <link rel="stylesheet" href="public/assets/css/produtos.css">
</head>
<body>

 <nav>
    <img src="public/assets/logo22.png" alt="entre_paginas" class="logo">

    <div class="nav-direita">

      <span class="nome-usuario">
        Olá, <?= htmlspecialchars($_SESSION['nome'] ?? 'Usuário') ?>!
      </span>

       <a class="nav-icone" href="index.php?controller=dashboard&action=index">
        <img src="public/assets/grafico1.png" alt="dashboard" class="dashboard">
      </a>

      <a class="nav-icone" href="index.php?controller=produto&action=index">
        <img src="public/assets/usuario.png" alt="vendedor" class="perfil-vendedor">
      </a>

    </div>
  </nav>

  <div class="conteudo">
    <div class="painel-cadastro">
      <h2 class="titulo"><?= $editar ? "Editar Produto #" . (int)$editar['id'] : "Cadastrar Produto" ?></h2>

      <form method="post" action="index.php?controller=produto&action=salvar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editar ? (int)$editar['id'] : 0 ?>">

        <div class="campo">
          <label class="rotulo" for="categoria">Categoria</label>
          <select class="selecionar-categoria" id="categoria" name="categoria_id" required>
            <option value="" disabled <?= !$editar ? 'selected' : '' ?>>Selecionar...</option>
            <?php foreach ($categorias as $c): ?>
              <option value="<?= (int)$c['id'] ?>"
                <?= $editar && (int)$editar['categoria_id'] === (int)$c['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nome']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="campo">
          <label class="rotulo" for="nome">Nome</label>
          <input class="texto" type="text" id="nome" name="nome" placeholder="Digitar..." required
                 value="<?= $editar ? htmlspecialchars($editar['nome']) : '' ?>" />
        </div>

        <div class="campo">
          <label class="rotulo" for="preco">Preço</label>
          <input class="texto" type="number" step="0.01" min="0" id="preco" name="preco" placeholder="Digitar..." required
                 value="<?= $editar ? htmlspecialchars($editar['preco'] ?? '') : '' ?>" />
        </div>

        <div class="campo">
          <label class="rotulo" for="estoque">Estoque</label>
          <input class="texto" type="number" step="1" min="0" id="estoque" name="estoque" placeholder="Digitar..." required
                 value="<?= $editar ? htmlspecialchars($editar['estoque'] ?? '') : '' ?>" />
        </div>

        <div class="campo">
          <label class="rotulo" for="descricao">
            Descrição <span class="opcional">(opcional)</span>
          </label>
          <textarea class="campo-descricao" id="descricao" name="descricao" placeholder="Digitar..."><?= $editar ?
              htmlspecialchars($editar['descricao'] ?? '') : '' ?></textarea>
        </div>

        <div class="campo">
          <label class="rotulo">
            Imagem do produto <span class="opcional">(opcional)</span>
          </label>
          <input type="file" class="file-real" id="imagem-input" name="imagem" accept=".jpg,.jpeg,.png,.webp"
                 onchange="document.getElementById('file-display').textContent = this.files[0] ? this.files[0].name : 'Nenhum arquivo'" />

          <div class="arquivos">
            <label for="imagem-input" class="botao-escolher">Escolher arquivo</label>
            <span class="nome-arquivo" id="file-display">Nenhum arquivo</span>
          </div>
          <p class="formato-arquivo">Formatos: JPG, PNG, WEBP (até 2MB). Salva como ID do produto.</p>
        </div>

        <div class="acoes-cadastro">
          <button class="botao-salvar" type="submit">Salvar</button>
          <button class="botao-limpar" type="button"
                  onclick="location.href='index.php?controller=produto&action=index'">Limpar</button>
        </div>
      </form>
    </div>

    <div class="painel-produtos">
      <h2 class="titulo">Lista de Produtos</h2>

      <div class="produtos-cabecalho">
        <span>Imagem</span>
        <span>ID</span>
        <span>Nome</span>
        <span>Categoria</span>
        <span>Preço</span>
        <span>Estoque</span>
        <span>Status</span>
        <span>Ações</span>
      </div>

      <?php foreach ($produtos as $p): ?>
      <div class="produtos">
        <div class="foto-produto">
          <img src="<?= imagemProdutoUrl((int)$p['id']) ?>" alt="produto"
               style="width:100%;height:100%;object-fit:cover;border-radius:6px;">
        </div>
        <span class="id-produto">#<?= (int)$p['id'] ?></span>
        <span class="nome-produto"><?= htmlspecialchars($p['nome']) ?></span>
        <span class="categoria-produto"><?= htmlspecialchars($p['categoria_nome']) ?></span>
        <span class="preco-produto">R$ <?= is_numeric($p['preco']) ? number_format((float)$p['preco'], 2, ',', '.') : '-' ?></span>
        <span class="estoque-produto"><?= htmlspecialchars((string)($p['estoque'] ?? '-')) ?></span>
        <span class="status"><?= ((int)$p['ativo'] === 1) ? 'Ativo' : 'Inativo' ?></span>

        <div class="acoes">
          <button class="botao-editar"
                  onclick="location.href='index.php?controller=produto&action=index&id=<?= (int)$p['id'] ?>'">Editar</button>

          <?php if ((int)$p['ativo'] === 1): ?>
            <button class="botao-inativar"
                    onclick="if(confirm('Inativar este produto?')) location.href='index.php?controller=produto&action=toggle&id=<?= (int)$p['id'] ?>&ativo=0'">Inativar</button>
          <?php else: ?>
            <button class="botao-inativar"
                    onclick="location.href='index.php?controller=produto&action=toggle&id=<?= (int)$p['id'] ?>&ativo=1'">Ativar</button>
          <?php endif; ?>

          <button class="botao-excluir"
                  onclick="if(confirm('⚠️ DELETAR permanentemente? Não há volta!')) location.href='index.php?controller=produto&action=deletar&id=<?= (int)$p['id'] ?>'">Excluir</button>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>

</body>
</html>