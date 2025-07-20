<?php
function login_check($username, $password) {
  $data = file_get_contents(__DIR__ . '/users.json');
  $json = json_decode($data, true);
  $users = $json['users'];

  foreach ($users as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
      return true;
    }
  }

  return false;
}


  $error = null;
  $success = null;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
      $error = "Username or password cannot be empty..!";
    } else {
      if (login_check($username, $password)) {
        $success = "✅ Logged in successfully! Welcome $username";
        // Optionally you can redirect:
        // header("Location: dashboard.php");
        // exit;
      } else {
        $error = "❌ Invalid username or password...";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(to right, #74ebd5, #acb6e5);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .menu {
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      display: block;
      margin: 10px 0 5px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .form-message {
      text-align: center;
      margin-top: 20px;
    }

    .form-message h3 {
      margin: 0;
    }
  </style>
</head>
<body>
  <div class="menu">
    <h2>Login</h2>
    <form action="" method="POST">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" placeholder="Enter username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter password" required>

      <input type="submit" name="login" value="Login">
    </form>

    <div class="form-message">
      <?php if($error): ?>
        <h3 style="color:red;"><?php echo $error; ?></h3>
      <?php endif; ?>
      <?php if($success): ?>
        <h3 style="color:green;"><?php echo $success; ?></h3>
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
  </div>
</body>
</html>
