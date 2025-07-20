<?php
require_once 'includes/auth.php';
session_start();

if (!is_logged_in()) {
  header("Location: login.php");
  exit;
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = $_POST['amount'] ?? '';
  $type = $_POST['type'] ?? '';
  $description = $_POST['description'] ?? '';
  $date = $_POST['date'] ?? '';

  if (empty($amount) || empty($type) || empty($description) || empty($date)) {
    $error = "All fields are required!";
  } else {
    $file = __DIR__ . '/transactions.json';

    // Initialize structure
    $data = ['transactions' => []];
    if (file_exists($file)) {
      $data = json_decode(file_get_contents($file), true);
      if (!isset($data['transactions']) || !is_array($data['transactions'])) {
        $data['transactions'] = [];
      }
    }

    // Append to transactions array
    $data['transactions'][] = [
      'username' => $_SESSION['username'],
      'amount' => (float)$amount,
      'type' => $type,
      'description' => $description,
      'date' => $date
    ];

    // Save back to JSON
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    $success = "Transaction added successfully ✅";
  }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <title>Adding Transaction</title>
  <style>
    body {
      background: #f4f4f4;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    button {
      background: #28a745;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      width: 100%;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background: #218838;
    }
    .message {
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
    }
    .back {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #007bff;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Adding Transaction</h2>
    <form method="POST">
      <input type="number" step="0.01" name="amount" placeholder="Amount" required>
      <select name="type" required>
        <option value="">Transaction Type</option>
        <option value="income">Incoming</option>
        <option value="expense">Amount</option>
      </select>
      <input type="date" name="date" required>
      <textarea name="description" placeholder="Explaination" required></textarea>
      <button type="submit">Submit Transaction </button>
    </form>

    <?php if ($error): ?>
      <div class="message" style="color: red;"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="message" style="color: green;"><?= $success ?></div>
    <?php endif; ?>

    <a href="dashboard.php" class="back">⬅ Back to dashboard</a>
  </div>
</body>
</html>
