
<?php
function password_checker($password) {
  if (strlen($password) < 6) return "Password must be at least 6 characters.";
  if (!preg_match('/[A-Z]/', $password)) return "Password must include at least one uppercase letter.";
  if (!preg_match('/[a-z]/', $password)) return "Password must include at least one lowercase letter.";
  if (!preg_match('/\d/', $password)) return "Password must include at least one number.";
  if (!preg_match('/[^a-zA-Z\d]/', $password)) return "Password must include at least one special character.";
  return true;
}

function register($username, $password) {
  $file = __DIR__ . '/users.json';
  $data = file_exists($file) ? file_get_contents($file) : '{"users":[]}';
  $json = json_decode($data, true);
  $users = $json['users'];

  foreach ($users as $user) {
    if (strtolower($user['username']) === strtolower($username)) {
      return "Username already exists.";
    }
  }

  $users[] = ['username' => $username, 'password' => $password];
  file_put_contents($file, json_encode(['users' => $users], JSON_PRETTY_PRINT));
  return true;
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    $error = "Username and password cannot be empty.";
  } else {
    $check = password_checker($password);
    if ($check !== true) {
      $error = $check;
    } else {
      $result = register($username, $password);
      if ($result === true) {
        $success = "Registration successful! Welcome, $username.";
      } else {
        $error = $result;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(to right, #6dd5fa, #2980b9);
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .menu {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      width: 350px;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .message {
      margin-top: 15px;
      font-weight: bold;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
    }
  </style>
</head>
<body>
  <div class="menu">
    <h2>Register</h2>
    <form action="" method="POST">
      <input type="text" name="username" placeholder="Enter username" required>
      <input type="password" name="password" placeholder="Enter password" required>
      <input type="submit" value="Register">
    </form>

    <div class="message">
      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php elseif ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
    </div>

  <div style="margin-top: 20px;">
   <a href="index.php" style="
    display: inline-block;
    padding: 10px 18px;
    background-color: #555;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease;
  " onmouseover="this.style.backgroundColor='#000'" onmouseout="this.style.backgroundColor='#555'">
    ⬅️ Back to Main Page
  </a>
  </div>
</body>
</html>
