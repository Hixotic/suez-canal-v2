<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "suez_monitor";


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4"); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
?>