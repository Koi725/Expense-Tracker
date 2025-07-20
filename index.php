<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Page</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      height: 100vh;
      background: linear-gradient(to right, #74ebd5, #acb6e5);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .menu {
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 100%;
      max-width: 400px;
    }

    h3 {
      color: #007bff;
      margin-bottom: 10px;
    }

    h5 {
      color: #555;
      margin-bottom: 30px;
    }

    a {
      display: inline-block;
      text-decoration: none;
      background-color: #007bff;
      color: white;
      padding: 12px 24px;
      margin: 0 10px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="menu">
    <h3>Welcome to the Expense Tracker</h3>
    <h5>Please log in or register if you don't have an account</h5>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
  </div>
</body>
</html>
