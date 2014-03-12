<?php
include ('../conn/connData.txt');
session_start();
//check if the user is existed or not
$email = $_POST['username'];
$password = $_POST['passwd'];

//connect the database
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//set up the sql search
$sql = 'Select ID, Name, MID FROM User where Email=? and PassWord=?';
$stmt = $mysqli->prepare($sql);
if(!$stmt){
	echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	echo '<a href="../login.html">BACK<<</a>';
}

$ID=NULL;
$Name=NULL;
$MID = NULL;
if(!$stmt->bind_param("ss", $email, $password)){
	echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	echo '<a href="../login.html">BACK<<</a>';
}

if(!$stmt->execute()){
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	echo '<a href="../login.html">BACK<<</a>';
}
//check if the user exist
if(!($stmt->bind_result($ID, $Name, $MID))){
	echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if($stmt->fetch() != null){
	$_SESSION['email'] = $email;
	$_SESSION['id'] = $ID;
	$_SESSION['name'] = $Name;
	$_SESSION['mid'] = $MID;
	$_SESSION[authed]="yes";
	Header( "Location: ../addCourses.php" ); 

}else{
	echo 'Wrong Email/Password!';
	header('Refresh: 1; URL=../login.html');

}
$stmt->close();
$mysqli->close();
?>