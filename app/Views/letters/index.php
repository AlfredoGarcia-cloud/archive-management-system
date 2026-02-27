<div class="bg-white rounded-lg p-4 shadow">
  <h2 class="font-semibold mb-4">Rekap Penomoran Surat</h2>
  <table data-datatable="true" class="display">
    <thead><tr><th>ID</th><th>Format</th><th>No Urut</th><th>Nomor Jadi</th><th>Keterangan</th><th>Waktu</th></tr></thead>
    <tbody>
    <?php foreach ($letterNumbers as $item): ?>
      <tr>
        <td><?= (int) $item['id'] ?></td>
        <td><?= htmlspecialchars($item['format_name']) ?></td>
        <td><?= htmlspecialchars((string) $item['sequence_no']) ?></td>
        <td><?= htmlspecialchars($item['generated_number']) ?></td>
        <td><?= htmlspecialchars($item['description']) ?></td>
        <td><?= htmlspecialchars($item['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
