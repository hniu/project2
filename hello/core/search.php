<?php
session_start();
if($_SESSION[authed]!='yes'){
header('location:login.html');
exit();
}
?>
<?php

$dbhost = "ix.cs.uoregon.edu";
$dbname = "MotiAdviser";
$dbuser = "guest";
$dbpass = "";
$port = "3469";

//	Connection
global $tutorial_db;

$tutorial_db = new mysqli();
$tutorial_db->connect($dbhost, $dbuser, $dbpass, $dbname, $port);
$tutorial_db->set_charset("utf8");

//	Check Connection

if ($tutorial_db->connect_errno) {
    printf("Connect failed: %s\n", $tutorial_db->connect_error);
    exit();
}

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $tutorial_db->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT * FROM Class WHERE CName LIKE "%'.$search_string.'%" OR CName LIKE "%'.$search_string.'%"';

	// Do Search
	$result = $tutorial_db->query($query);

	while($row = $result->fetch_row()) {

		echo '<li class="result"><a target="ratings" href="ratings.php?cid='. $row[0] .'"><h3>' . $row[1] . '</h3></a></li><br>';

	}
}
?>