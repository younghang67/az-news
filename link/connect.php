<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "news";

$conn = new mysqli("$servername", "$username", "$password", "$database");

if ($conn->connect_error) {
    die("connection failed");
}
