<div class="bg-white rounded-lg p-4 shadow">
  <h2 class="font-semibold mb-4">Manajemen User</h2>
  <table data-datatable="true" class="display">
    <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr>
        <td><?= (int) $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role_name']) ?></td>
        <td><?= (int) $user['is_active'] === 1 ? 'Aktif' : 'Nonaktif' ?></td>
        <td>
          <form action="/users/toggle-active" method="post" class="inline">
            <input type="hidden" name="user_id" value="<?= (int) $user['id'] ?>">
            <input type="hidden" name="is_active" value="<?= (int) $user['is_active'] === 1 ? 0 : 1 ?>">
            <button class="px-3 py-1 rounded text-white <?= (int) $user['is_active'] === 1 ? 'bg-red-600' : 'bg-green-600' ?>">
              <?= (int) $user['is_active'] === 1 ? 'Nonaktifkan' : 'Aktifkan' ?>
            </button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
