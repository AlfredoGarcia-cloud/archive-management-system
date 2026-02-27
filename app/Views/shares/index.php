<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <div class="bg-white rounded-lg p-4 shadow">
    <h2 class="font-semibold mb-4">Share Folder</h2>
    <form action="/shares/folders" method="post" class="space-y-3">
      <select name="folder_id" class="w-full border rounded px-3 py-2" required>
        <option value="">Pilih Folder</option>
        <?php foreach ($folders as $folder): ?>
          <option value="<?= (int) $folder['id'] ?>"><?= htmlspecialchars($folder['path']) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="user_id" class="w-full border rounded px-3 py-2" required>
        <option value="">Pilih User</option>
        <?php foreach ($users as $user): ?>
          <option value="<?= (int) $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</option>
        <?php endforeach; ?>
      </select>
      <div class="flex gap-3 text-sm">
        <label><input type="checkbox" name="can_read" checked> read</label>
        <label><input type="checkbox" name="can_create"> create</label>
        <label><input type="checkbox" name="can_update"> update</label>
        <label><input type="checkbox" name="can_delete"> delete</label>
      </div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Share Folder</button>
    </form>
  </div>

  <div class="bg-white rounded-lg p-4 shadow">
    <h2 class="font-semibold mb-4">Share File (Arsip)</h2>
    <form action="/shares/archives" method="post" class="space-y-3">
      <select name="archive_id" class="w-full border rounded px-3 py-2" required>
        <option value="">Pilih Arsip</option>
        <?php foreach ($archives as $archive): ?>
          <option value="<?= (int) $archive['id'] ?>"><?= htmlspecialchars($archive['title']) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="user_id" class="w-full border rounded px-3 py-2" required>
        <option value="">Pilih User</option>
        <?php foreach ($users as $user): ?>
          <option value="<?= (int) $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</option>
        <?php endforeach; ?>
      </select>
      <div class="flex gap-3 text-sm">
        <label><input type="checkbox" name="can_read" checked> read</label>
        <label><input type="checkbox" name="can_update"> update</label>
        <label><input type="checkbox" name="can_delete"> delete</label>
      </div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Share File</button>
    </form>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
  <div class="bg-white rounded-lg p-4 shadow">
    <h3 class="font-semibold mb-3">Daftar Share Folder</h3>
    <table data-datatable="true" class="display">
      <thead><tr><th>Folder</th><th>User</th><th>read</th><th>create</th><th>update</th><th>delete</th></tr></thead>
      <tbody>
      <?php foreach ($folderShares as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['folder_path']) ?></td>
        <td><?= htmlspecialchars($s['target_user']) ?></td>
        <td><?= (int) $s['can_read'] ?></td><td><?= (int) $s['can_create'] ?></td><td><?= (int) $s['can_update'] ?></td><td><?= (int) $s['can_delete'] ?></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="bg-white rounded-lg p-4 shadow">
    <h3 class="font-semibold mb-3">Daftar Share File</h3>
    <table data-datatable="true" class="display">
      <thead><tr><th>Arsip</th><th>User</th><th>read</th><th>update</th><th>delete</th></tr></thead>
      <tbody>
      <?php foreach ($archiveShares as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['archive_title']) ?></td>
        <td><?= htmlspecialchars($s['target_user']) ?></td>
        <td><?= (int) $s['can_read'] ?></td><td><?= (int) $s['can_update'] ?></td><td><?= (int) $s['can_delete'] ?></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
