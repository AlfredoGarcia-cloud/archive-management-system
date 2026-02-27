<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="bg-white rounded-lg p-4 shadow lg:col-span-1">
    <h2 class="font-semibold mb-3">Buat Folder Baru</h2>
    <form method="post" action="/folders" class="space-y-3">
      <input name="name" placeholder="Nama Folder" required class="w-full border rounded px-3 py-2"/>
      <input name="path" placeholder="Contoh: /legal/2026" required class="w-full border rounded px-3 py-2"/>
      <input name="parent_id" type="number" placeholder="Parent ID (opsional)" class="w-full border rounded px-3 py-2"/>
      <button class="bg-blue-600 text-white rounded px-4 py-2 w-full">Simpan</button>
    </form>
  </div>
  <div class="bg-white rounded-lg p-4 shadow lg:col-span-2">
    <table data-datatable="true" class="display">
      <thead><tr><th>ID</th><th>Nama</th><th>Path</th><th>Parent</th><th>Dibuat</th></tr></thead>
      <tbody>
      <?php foreach ($folders as $folder): ?>
        <tr>
          <td><?= (int) $folder['id'] ?></td>
          <td><?= htmlspecialchars($folder['name']) ?></td>
          <td><?= htmlspecialchars($folder['path']) ?></td>
          <td><?= htmlspecialchars((string) ($folder['parent_id'] ?? '-')) ?></td>
          <td><?= htmlspecialchars($folder['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
