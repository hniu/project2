<?php
include ('../conn/connData.txt');
$email = $_POST['email'];

//connect the database
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//set up the sql search
$sql = 'Select Name, PassWord FROM User where Email=?';
$stmt = $mysqli->prepare($sql);
if(!$stmt){
	echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	echo '<a href="../login.html">BACK<<</a>';
}

$password = NULL;
$name = NULL;
if(!$stmt->bind_param("s", $email)){
	echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	echo '<a href="../login.html">BACK<<</a>';
}

if(!$stmt->execute()){
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	echo '<a href="../login.html">BACK<<</a>';
}
//check if the user exist
if(!($stmt->bind_result($name, $password))){
	echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if($stmt->fetch() != null){
	echo 'The password has sent to your email, please check it.';
	echo '<a href="../login.html">BACK<<</a>';
}else{//email does not exist
	echo 'Email does not exist!';
	header('Refresh: 1; URL=../login.html');
}


$to      = $email; // Send email to our user
$subject = 'Reset-Password On HelloCourses'; // Give the email a subject 
$message = '

Hello, '.$name.'

You recently asked to reset your password on HelloCourses. To complete your request, your current password is: 

------------------------
Password: '.$password.'
------------------------

Please click this link to login your account:
http://ix.cs.uoregon.edu/~hanqing/Project2/HelloCourses/login.html

Thanks,
HelloCourses
'; // Our message above including the link
                     
$headers = 'From:noreply@hellocourses.com' . "\r\n" .
		'Reply-To: hanqing@uoregon.edu' . "\r\n" .
		'X-Mailer: PHP/' . phpversion(); //set the header
mail($to, $subject, $message, $headers); // Send our email

?>