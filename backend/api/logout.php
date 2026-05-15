<?php
// Start session
session_start();

// Remove all session data
session_unset();

// Destroy session
session_destroy();

// Redirect to login page
header("Location: /Web-Dev-Group-Project/frontend/index.php");

exit();

?>