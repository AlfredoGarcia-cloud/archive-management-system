<div class="bg-white rounded-lg p-4 shadow">
  <h2 class="font-semibold mb-4">Audit Trail Aktivitas User</h2>
  <table data-datatable="true" class="display">
    <thead><tr><th>User</th><th>Aksi</th><th>Entitas</th><th>ID Entitas</th><th>Deskripsi</th><th>IP</th><th>Waktu</th></tr></thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
      <tr>
        <td><?= htmlspecialchars($log['user_name']) ?></td>
        <td><?= htmlspecialchars($log['action']) ?></td>
        <td><?= htmlspecialchars($log['entity_type']) ?></td>
        <td><?= (int) $log['entity_id'] ?></td>
        <td><?= htmlspecialchars($log['description']) ?></td>
        <td><?= htmlspecialchars($log['ip_address']) ?></td>
        <td><?= htmlspecialchars($log['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
