<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'Archive Management') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-dt@2.0.8/css/dataTables.dataTables.min.css">
</head>
<body class="bg-gray-50 text-gray-800">
<div class="min-h-screen">
  <nav class="bg-white border-b p-4 flex gap-4 flex-wrap">
    <a href="/dashboard">Dashboard</a>
    <a href="/folders">Folder</a>
    <a href="/archives">Arsip</a>
    <a href="/letter-numbers">Penomoran Surat</a>
    <a href="/categories">Kategori</a>
    <a href="/activity-logs">Log Aktivitas</a>
    <a href="/shares">Share</a>
    <a href="/users">Users</a>
    <a href="/logout" class="ml-auto text-red-600">Logout</a>
  </nav>
  <main class="p-6">
