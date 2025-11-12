<?php require __DIR__ . '/../layout/header.php'; ?>
<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES); }
if (!empty($_SESSION['success'])) { echo "<div class='alert success'>".e($_SESSION['success'])."</div>"; unset($_SESSION['success']); }
if (!empty($_SESSION['error']))   { echo "<div class='alert error'>".e($_SESSION['error'])."</div>"; unset($_SESSION['error']); }
?>

<section class="card">
  <h2>Livros (<?= count($books) ?>)</h2>
  <?php if (empty($books)): ?>
    <p class="muted">Nenhum livro cadastrado.</p>
  <?php else: ?>
  <table class="table">
    <thead>
      <tr><th>#</th><th>Título</th><th>Autor</th><th>Gênero</th><th>Data</th><th>Estoque</th><th>Ações</th></tr>
    </thead>
    <tbody>
    <?php foreach ($books as $b): ?>
      <tr>
        <td><?= e($b['id']) ?></td>
        <td><?= e($b['titulo']) ?></td>
        <td><?= e($b['autor']) ?></td>
        <td><?= e($b['genero']) ?></td>
        <td><?= $b['data_lancamento'] ? date('d/m/Y', strtotime($b['data_lancamento'])) : '-' ?></td>
        <td><?= e($b['estoque']) ?></td>
        <td>
          <a class="btn" href="/index.php?action=edit&id=<?= e($b['id']) ?>">Editar</a>
          <a class="btn danger" href="/index.php?action=delete&id=<?= e($b['id']) ?>" onclick="return confirmDelete()">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
