<div class="bg-white rounded-lg p-4 shadow">
  <table data-datatable="true" class="display">
    <thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Folder</th><th>Ringkasan</th><th>Preview PDF</th></tr></thead>
    <tbody>
    <?php foreach ($archives as $archive): ?>
      <tr>
        <td><?= (int) $archive['id'] ?></td>
        <td><?= htmlspecialchars($archive['title']) ?></td>
        <td><?= htmlspecialchars($archive['category_name']) ?></td>
        <td><?= htmlspecialchars($archive['folder_path']) ?></td>
        <td><?= htmlspecialchars($archive['summary']) ?></td>
        <td><a target="_blank" href="<?= htmlspecialchars($archive['file_path']) ?>" class="text-blue-600">Lihat PDF</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
