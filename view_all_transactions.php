<?php
require_once 'includes/auth.php';
session_start();

// Make sure user is logged in and is admin
if (!is_logged_in() || !is_admin()) {
  header("Location: login.php");
  exit;
}

$file = __DIR__ . '/transactions.json';
$transactions = [];

if (file_exists($file)) {
  $transactions = json_decode(file_get_contents($file), true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Transactions (Admin View)</title>
  <style>
    body {
      background: #f0f2f5;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
    }
    .container {
      max-width: 1000px;
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
      background-color: #343a40;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
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
    <h2>All User Transactions (Admin View)</h2>

    <?php if (empty($transactions)): ?>
      <p style="text-align:center; color: gray;">No transactions found.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Description</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transactions as $tx): ?>
            <tr>
              <td><?= htmlspecialchars($tx['owner']) ?></td>
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
