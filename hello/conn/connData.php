<?php

$server = "ix.cs.uoregon.edu";
$dbname ="MotiAdviser";
$user = "guest";
$pass = "";
$port="3469";

session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$trackid=$_SESSION['mid'];
//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>