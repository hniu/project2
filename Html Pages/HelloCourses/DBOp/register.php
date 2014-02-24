<?php
include ('../conn/connData.txt');

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$mysqli = new mysqli($server, $user, $pass, $dbname, $port);

if(mysqli_connect_errno()) {
      echo "Connection Failed: " . mysqli_connect_errno();
      exit();
}

function checkExist(){
	global $mysqli;
	global $email;
	$stmt = $mysqli->prepare("SELECT Email FROM User WHERE Email = ?");
	$stmt->bind_param('s', $email);
    	$stmt->execute();
	if($stmt->fetch()){
		$stmt->close();
		return true;
	}
	$stmt->close();
	return false;
}


if(!checkExist()){
	$stmt = $mysqli->prepare("INSERT INTO User(Email,Password,Name) VALUES (?,?,?)");
	if (!($stmt)) {
  	  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$stmt->bind_param("sss", $email, $username, $password);
	// execute the statement
	$stmt->execute();
	$stmt->close();
	echo 'Hi '.$username.', you have registered Motivity Products';
	echo '<a href="../login.html"> Home </a> ';
}else{
	echo 'Sorry, the email already exist!';
	echo '<a href="../login.html"> Home </a> ';
}

$mysqli->close();

?>