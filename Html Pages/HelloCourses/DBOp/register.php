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
$stmt = $mysqli->prepare("INSERT INTO User(Email,Password,Name) VALUES (?,?,?)");
if (!($stmt)) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if ($stmt = $dbc->prepare("SELECT Name FROM User WHERE Name = ?"))
    {
    $stmt->bind_param('s', $username);

    $stmt->execute();

    if($stmt != FALSE)
    {           
        $usernameError = "Username already exists!";
    }
    else
    {
        $usernameError = "";
    }

    $stmt1->close();
	}
else{
	$stmt->bind_param("sss", $email, $username, $password);
	}
// execute the statement
$stmt->execute();
echo 'An user has been added into the DEX_database!';
?>