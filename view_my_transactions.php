<?php
require_once 'includes/auth.php';
session_start();

// Make sure user is logged in
if (!is_logged_in()) {
  header("Location: login.php");
  exit;
}

$currentUser = get_current_user();
$transactions = [];

$file = __DIR__ . '/transactions.json';
if (file_exists($file)) {
  $allTransactions = json_decode(file_get_contents($file), true);
  foreach ($allTransactions as $tx) {
    if ($tx['owner'] === $currentUser) {
      $transactions[] = $tx;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Transactions</title>
  <style>
    body {
      background: #eef1f5;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f8f8f8;
    }
    .back-link {
      display: inline-block;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2><?= htmlspecialchars($currentUser) ?>'s Transactions</h2>

    <?php if (empty($transactions)): ?>
      <p style="text-align:center; color: gray;">No transactions found.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Amount</th>
            <th>Type</th>
            <th>Description</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transactions as $tx): ?>
            <tr>
              <td><?= htmlspecialchars($tx['amount']) ?></td>
              <td><?= ucfirst($tx['type']) ?></td>
              <td><?= htmlspecialchars($tx['description']) ?></td>
              <td><?= htmlspecialchars($tx['date']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
  </div>
</body>
</html>
