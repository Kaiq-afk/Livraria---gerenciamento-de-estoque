<?php require __DIR__ . '/../layout/header.php'; ?>
<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES); }
$editing = !empty($book);
if (!empty($_SESSION['error'])) { echo "<div class='alert error'>".e($_SESSION['error'])."</div>"; unset($_SESSION['error']); }
?>

<section class="card">
  <h2><?= $editing ? 'Editar Livro' : 'Adicionar Livro' ?></h2>
  <form method="post" action="/index.php?action=<?= $editing ? 'update' : 'store' ?>" onsubmit="return validateForm(this)">
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= e($book['id']) ?>"><?php endif; ?>

    <label>Título
      <input type="text" name="titulo" required maxlength="255" value="<?= e($book['titulo'] ?? '') ?>">
    </label>

    <label>Autor
      <input type="text" name="autor" required maxlength="255" value="<?= e($book['autor'] ?? '') ?>">
    </label>

    <label>Gênero
      <input type="text" name="genero" required maxlength="100" value="<?= e($book['genero'] ?? '') ?>">
    </label>

    <label>Data de lançamento
      <input type="date" name="data_lancamento" value="<?= e($book['data_lancamento'] ?? '') ?>">
    </label>

    <label>Estoque
      <input type="number" name="estoque" min="0" value="<?= e($book['estoque'] ?? 0) ?>">
    </label>

    <div class="actions">
      <button class="btn primary" type="submit"><?= $editing ? 'Salvar' : 'Adicionar' ?></button>
      <a class="btn" href="/index.php">Cancelar</a>
    </div>
  </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
