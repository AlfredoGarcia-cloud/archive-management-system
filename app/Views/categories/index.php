<div class="bg-white rounded-lg p-4 shadow">
  <h2 class="font-semibold mb-4">Kategori Surat</h2>
  <table data-datatable="true" class="display">
    <thead><tr><th>ID</th><th>Kode</th><th>Nama</th><th>Deskripsi</th></tr></thead>
    <tbody>
    <?php foreach ($categories as $category): ?>
      <tr>
        <td><?= (int) $category['id'] ?></td>
        <td><?= htmlspecialchars($category['code']) ?></td>
        <td><?= htmlspecialchars($category['name']) ?></td>
        <td><?= htmlspecialchars($category['description']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
