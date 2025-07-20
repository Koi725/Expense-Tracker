<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Load transactions
$transactionsData = file_exists(__DIR__.'/transactions.json')
  ? json_decode(file_get_contents(__DIR__.'/transactions.json'), true)
  : ['transactions' => []];

$allTransactions = $transactionsData['transactions'];
$userTransactions = array_filter($allTransactions, fn($txn) => $txn['username'] === $username);

// Admin only: count users
$totalUsers = 0;
if ($role === 'admin') {
  $usersData = file_exists(__DIR__.'/users.json')
    ? json_decode(file_get_contents(__DIR__.'/users.json'), true)
    : ['users' => []];
  $totalUsers = count($usersData['users']);
}

$totalTransactions = count($allTransactions);
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
    h2, h3 {
      color: #333;
    }
    a {
      text-decoration: none;
      color: blue;
      font-weight: bold;
    }
    a:hover {
      color: darkblue;
    }
    .admin {
      background-color: #ffe0e0;
    }
    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
    }
    ul {
      padding-left: 20px;
    }
    li {
      margin-bottom: 8px;
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
      <h3>💳 Total Transactions: <?= $totalTransactions ?></h3>
      <p><a href="view_all_transactions.php">📊 View All Transactions</a></p>
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
      <a href="add_transaction.php">➕ Add New Transaction</a><br><br>
      <a href="view_my_transactions.php">📋 View My Transactions</a>
    </div>
  <?php endif; ?>

</body>
</html>
