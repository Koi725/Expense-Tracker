<?php
session_start();
session_unset();   // Clear session variables
session_destroy(); // Destroy the session
setcookie(session_name(), '', time() - 3600); // Optional: clear session cookie
header("Location: index.php");
exit;
?>