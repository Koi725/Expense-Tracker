<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$transactionsData = json_decode(file_get_contents(__DIR__.'/transactions.json'), true);

$userTransactions = array_filter($transactionsData['transactions'], function($txn) use ($username) {
  return $txn['username'] === $username;
});

$totalUsers = 0;
if ($role === 'admin') {
  $usersData = json_decode(file_get_contents(__DIR__.'/users.json'), true);
  $totalUsers = count($usersData['users']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - <?= htmlspecialchars($username) ?></title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      padding: 30px;
    }
    .card {
      background: white;
      padding: 20px;
      margin-bottom: 15px;
      border-radius: 12px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    h2 {
      color: #333;
    }
    a {
      text-decoration: none;
      color: blue;
      font-weight: bold;
    }
    .admin {
      background-color: #ffe0e0;
    }
    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
    }
  </style>
</head>
<body>

  <div class="logout"><a href="logout.php">🚪 Logout</a></div>

  <div class="card <?= $role === 'admin' ? 'admin' : '' ?>">
    <h2>Hello, <?= htmlspecialchars($username) ?>!</h2>
    <p>Your role: <strong><?= htmlspecialchars($role) ?></strong></p>
  </div>

  <?php if ($role === 'admin'): ?>
    <div class="card">
      <h3>👥 Total Registered Users: <?= $totalUsers ?></h3>
      <h3>💳 Total Transactions: <?= count($transactionsData['transactions']) ?></h3>
      <a href="view_all_transactions.php">📊 View All Transactions</a>
    </div>
  <?php else: ?>
    <div class="card">
      <h3>💸 Your Transactions:</h3>
      <?php if (empty($userTransactions)): ?>
        <p>You don't have any transactions yet.</p>
      <?php else: ?>
        <ul>
          <?php foreach ($userTransactions as $txn): ?>
            <li><?= htmlspecialchars($txn['amount']) ?> € - <?= htmlspecialchars($txn['category']) ?> - <?= htmlspecialchars($txn['date']) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <br>
      <a href="add_transaction.php">➕ Add New Transaction</a>
    </div>
  <?php endif; ?>

</body>
</html>
