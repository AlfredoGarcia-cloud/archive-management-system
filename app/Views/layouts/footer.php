  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/preline@2.4.1/dist/preline.min.js"></script>
<script>
  document.querySelectorAll('table[data-datatable="true"]').forEach((table) => {
    new DataTable(table);
  });

  <?php if (!empty($_SESSION['success'])): ?>
  Swal.fire({ icon: 'success', title: 'Sukses', text: '<?= addslashes($_SESSION['success']) ?>' });
  <?php unset($_SESSION['success']); endif; ?>

  <?php if (!empty($_SESSION['error'])): ?>
  Swal.fire({ icon: 'error', title: 'Oops', text: '<?= addslashes($_SESSION['error']) ?>' });
  <?php unset($_SESSION['error']); endif; ?>
</script>
</body>
</html>
