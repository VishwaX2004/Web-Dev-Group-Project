<?php
// ============================================
// DATABASE CONNECTION
// ============================================

// Database credentials
$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "retail_system";
$port = 3307;

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

// Check connection
if (!$conn) {

    die("Database Connection Failed: " . mysqli_connect_error());

}

// UTF8 support
mysqli_set_charset($conn, "utf8");
?>