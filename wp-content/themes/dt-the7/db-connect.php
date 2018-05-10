<?php
$servername = "localhost";
$username = "webguruzuser";
$password = "AO(Xu;bOe_PK";
$dbname = "webguruzdb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
}
?>