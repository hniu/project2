<html>
<head>
<title>All Courses</title>
</head>
<body>
<?php
include ('../conn/connData.txt');

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$courses = array();
// find the course name according to its id
function findCourses(){
	global $mysqli;
	$sql = 'SELECT CID, CName, Description,EvaluationRate, EvaluationNumber FROM Class';
	$CName = NULL;
	$des = NULL;
	$score = NULL;
	$total = NULL;
	$CID = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($CID,$CName, $des, $score, $total);
	while($stmt->fetch()){
		echo $CID . ' ' . $CName;
		echo '<br>';
		echo $des;
		echo "<br><Strong>Rating: ";
		if ($score == NULL){
			echo "0";
		}else{
			echo $score;
		}
		echo "</Strong><br>";
		echo "<Strong>Rating By ";
		if ($total == NULL){
			echo "0";
		}else{
			echo $score;
		}
		echo " People</Strong><br>";
		echo '<br><font color=blue>Course Description:';
		if(strlen($des) == 1){
			echo 'None';
		}else{
			echo $des;
		}
		echo '</font><br><br>';
	}
	$stmt->close();
}
//show all the courese
findCourses();
$mysqli->close();
?>
</body>
</html>