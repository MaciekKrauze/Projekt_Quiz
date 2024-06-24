<?php
$servername = "szuflandia.pjwstk.edu.pl";
$username = "s29747";
$password = "Mac.Krau";
$dbname = "s29747";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>